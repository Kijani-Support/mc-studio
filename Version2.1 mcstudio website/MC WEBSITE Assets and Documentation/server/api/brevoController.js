import * as brevo from "@getbrevo/brevo";

// Initialize Brevo API
const apiKey = process.env.BREVO_API_KEY;
const listId = parseInt(process.env.BREVO_LIST_ID);

// Contacts API instance
const contactsApi = new brevo.ContactsApi();
contactsApi.setApiKey(brevo.ContactsApiApiKeys.apiKey, apiKey);

// Transactional Emails API instance
const emailApi = new brevo.TransactionalEmailsApi();
emailApi.setApiKey(brevo.TransactionalEmailsApiApiKeys.apiKey, apiKey);

/**
 * Subscribe user to newsletter via Brevo
 * POST /api/subscribe
 */
export const subscribeToNewsletter = async (req, res) => {
  try {
    const { email, firstName } = req.body;

    // Validate email
    if (!email || !email.includes('@')) {
      return res.status(400).json({ error: 'Valid email is required' });
    }

    // Create contact and add to newsletter list
    const createContact = new brevo.CreateContact({
      email: email,
      attributes: {
        FIRSTNAME: firstName || '',
      },
      listIds: [listId],
      updateEnabled: true, // Update if contact already exists
    });

    await contactsApi.createContact(createContact);

    // Send welcome email via transactional template
    const sendSmtpEmail = new brevo.SendSmtpEmail({
      to: [{ email: email }],
      templateId: parseInt(process.env.BREVO_WELCOME_TEMPLATE_ID) || 1, // Your Brevo template ID
      params: {
        firstName: firstName || 'Subscriber',
      },
    });

    await emailApi.sendTransacEmail(sendSmtpEmail);

    res.status(200).json({
      success: true,
      message: 'Successfully subscribed to newsletter!',
    });
  } catch (error) {
    console.error('Newsletter subscription error:', error);
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
export const handleContactForm = async (req, res) => {
  try {
    const { firstName, lastName, email, phone, subject, message } = req.body;

    // Validate required fields
    if (!firstName || !lastName || !email || !subject || !message) {
      return res.status(400).json({
        error: 'First name, last name, email, subject, and message are required',
      });
    }

    // Add contact to Brevo (not necessarily to newsletter list)
    const createContact = new brevo.CreateContact({
      email: email,
      attributes: {
        FIRSTNAME: firstName,
        LASTNAME: lastName,
        PHONE: phone || '',
        CONTACT_SUBJECT: subject,
      },
      // Don't add to list if user doesn't explicitly subscribe
      updateEnabled: true,
    });

    await contactsApi.createContact(createContact);

    // Send contact form received email to customer
    const customerEmail = new brevo.SendSmtpEmail({
      to: [{ email: email }],
      templateId: parseInt(process.env.BREVO_CONTACT_CONFIRMATION_TEMPLATE_ID) || 2,
      params: {
        firstName: firstName,
        subject: subject,
      },
    });

    await emailApi.sendTransacEmail(customerEmail);

    // Send notification to your team
    const teamEmail = new brevo.SendSmtpEmail({
      to: [{ email: process.env.CONTACT_NOTIFICATION_EMAIL || 'contact@modusadora.com' }],
      subject: `New Contact Form Submission: ${subject}`,
      htmlContent: `
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> ${firstName} ${lastName}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Phone:</strong> ${phone || 'Not provided'}</p>
        <p><strong>Subject:</strong> ${subject}</p>
        <p><strong>Message:</strong></p>
        <p>${message.replace(/\n/g, '<br>')}</p>
      `,
    });

    await emailApi.sendTransacEmail(teamEmail);

    res.status(200).json({
      success: true,
      message: 'Your message has been sent successfully!',
    });
  } catch (error) {
    console.error('Contact form error:', error);
    res.status(500).json({
      error: 'Failed to send message',
      details: error.message,
    });
  }
};
