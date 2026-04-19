const BREVO_API_URL = 'https://api.brevo.com/v3';

// Helper to get headers with the API key
const getHeaders = () => ({
  'accept': 'application/json',
  'content-type': 'application/json',
  'api-key': process.env.BREVO_API_KEY,
});

/**
 * Subscribe user to newsletter via Brevo
 * POST /api/subscribe
 */
exports.subscribeToNewsletter = async (req, res) => {
  try {
    const { email, firstName } = req.body;

    if (!email || !email.includes('@')) {
      return res.status(400).json({ error: 'Valid email is required' });
    }

    const listId = parseInt(process.env.BREVO_LIST_ID);

    // 1. Create/Update Contact
    const contactResponse = await fetch(`${BREVO_API_URL}/contacts`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({
        email: email,
        attributes: { FIRSTNAME: firstName || '' },
        listIds: [listId],
        updateEnabled: true,
      }),
    });

    if (!contactResponse.ok) {
      const errorText = await contactResponse.text();
      console.warn('Contact creation warning (might already exist):', errorText);
    }

    // 2. Send Welcome Email Template
    const emailResponse = await fetch(`${BREVO_API_URL}/smtp/email`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({
        to: [{ email: email }],
        templateId: parseInt(process.env.BREVO_WELCOME_TEMPLATE_ID) || 1,
        params: { firstName: firstName || 'Subscriber' },
      }),
    });

    if (!emailResponse.ok) {
      const errorText = await emailResponse.text();
      throw new Error(`Failed to send welcome email: ${errorText}`);
    }

    res.status(200).json({
      success: true,
      message: 'Successfully subscribed to newsletter!',
    });
  } catch (error) {
    console.error('Newsletter error:', error.message);
    res.status(500).json({
      error: 'Failed to subscribe to newsletter',
      details: error.message,
    });
  }
};

/**
 * Handle contact form submission via Brevo
 * POST /api/contact
 */
exports.handleContactForm = async (req, res) => {
  try {
    const { firstName, lastName, email, phone, subject, message } = req.body;

    if (!firstName || !lastName || !email || !subject || !message) {
      return res.status(400).json({
        error: 'First name, last name, email, subject, and message are required',
      });
    }

    // 1. Add contact to Brevo database
    const contactResponse = await fetch(`${BREVO_API_URL}/contacts`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({
        email: email,
        attributes: {
          FIRSTNAME: firstName,
          LASTNAME: lastName,
          PHONE: phone || '',
          CONTACT_SUBJECT: subject,
        },
        updateEnabled: true,
      }),
    });

    if (!contactResponse.ok) {
      const errorText = await contactResponse.text();
      console.warn('Contact creation warning:', errorText);
    }

    // 2. Send confirmation template to the customer
    const customerEmailResponse = await fetch(`${BREVO_API_URL}/smtp/email`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({
        to: [{ email: email }],
        templateId: parseInt(process.env.BREVO_CONTACT_CONFIRMATION_TEMPLATE_ID) || 2,
        params: {
          firstName: firstName,
          subject: subject,
        },
      }),
    });

    if (!customerEmailResponse.ok) {
      const errorText = await customerEmailResponse.text();
      console.error('Failed to send customer confirmation:', errorText);
    }

    // 3. Send raw HTML notification to your team
    const teamEmailResponse = await fetch(`${BREVO_API_URL}/smtp/email`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify({
        sender: {
          email: process.env.SMTP_FROM_EMAIL || 'noreply@mcstudio.com',
          name: 'MC Studio Website'
        },
        to: [{ email: process.env.CONTACT_NOTIFICATION_EMAIL || 'contact@mcstudio.com' }],
        subject: `New Contact Form Submission: ${subject}`,
        htmlContent: `
          <h2>New Contact Form Submission</h2>
          <p><strong>Name:</strong> ${firstName} ${lastName}</p>
          <p><strong>Email:</strong> ${email}</p>
          <p><strong>Phone:</strong> ${phone || 'Not provided'}</p>
          <p><strong>Subject:</strong> ${subject}</p>
          <p><strong>Message:</strong></p>
          <p>${message.replace(/\n/g, '<br>')}</p>
        `
      }),
    });

    if (!teamEmailResponse.ok) {
      const errorText = await teamEmailResponse.text();
      throw new Error(`Failed to send team notification: ${errorText}`);
    }

    res.status(200).json({
      success: true,
      message: 'Your message has been sent successfully!',
    });
  } catch (error) {
    console.error('Contact form error:', error.message);
    res.status(500).json({
      error: 'Failed to send message',
      details: error.message,
    });
  }
};