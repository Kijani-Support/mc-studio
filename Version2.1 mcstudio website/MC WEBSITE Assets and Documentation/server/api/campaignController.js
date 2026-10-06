const BREVO_API_URL = 'https://api.brevo.com/v3';

// Helper for headers to ensure process.env is read at runtime
const getHeaders = () => ({
  'accept': 'application/json',
  'content-type': 'application/json',
  'api-key': process.env.BREVO_API_KEY,
});

/**
 * Get all campaigns from Brevo
 * GET /api/campaigns?limit=50&offset=0&status=sent
 */
exports.getAllCampaigns = async (req, res) => {
  try {
    const { limit = 50, offset = 0, status } = req.query;

    let url = `${BREVO_API_URL}/emailCampaigns?limit=${limit}&offset=${offset}`;
    if (status) url += `&status=${status}`;

    const response = await fetch(url, {
      method: 'GET',
      headers: getHeaders(),
    });

    if (!response.ok) throw new Error(`Failed to fetch campaigns: ${response.statusText}`);
    
    const result = await response.json();
    res.status(200).json({ success: true, data: result.campaigns, count: result.count });
  } catch (error) {
    console.error('Get campaigns error:', error);
    res.status(500).json({ error: 'Failed to retrieve campaigns', details: error.message });
  }
};

/**
 * Get campaign by ID from Brevo
 * GET /api/campaign/:campaignId
 */
exports.getCampaign = async (req, res) => {
  try {
    const { campaignId } = req.params;
    if (!campaignId) return res.status(400).json({ error: 'Campaign ID is required' });

    const response = await fetch(`${BREVO_API_URL}/emailCampaigns/${campaignId}`, {
      method: 'GET',
      headers: getHeaders(),
    });

    if (!response.ok) throw new Error(`Failed to fetch campaign: ${response.statusText}`);
    
    const campaign = await response.json();
    res.status(200).json({ success: true, data: campaign });
  } catch (error) {
    console.error('Get campaign error:', error);
    res.status(500).json({ error: 'Failed to retrieve campaign', details: error.message });
  }
};

/**
 * Update campaign in Brevo
 * PUT /api/campaign/:campaignId
 */
exports.updateCampaign = async (req, res) => {
  try {
    const { campaignId } = req.params;
    const { subject, htmlContent, fromEmail, fromName, scheduledAt } = req.body;

    if (!campaignId) return res.status(400).json({ error: 'Campaign ID is required' });

    const updateData = {};
    if (subject) updateData.subject = subject;
    if (htmlContent) updateData.htmlContent = htmlContent;
    if (fromEmail || fromName) {
      updateData.sender = { name: fromName || 'ModusChora Studio', email: fromEmail };
    }
    if (scheduledAt) updateData.scheduledAt = scheduledAt;

    const response = await fetch(`${BREVO_API_URL}/emailCampaigns/${campaignId}`, {
      method: 'PUT',
      headers: getHeaders(),
      body: JSON.stringify(updateData),
    });

    if (!response.ok) throw new Error(`Failed to update campaign: ${response.statusText}`);
    res.status(200).json({ success: true, message: 'Campaign updated successfully!' });
  } catch (error) {
    console.error('Update campaign error:', error);
    res.status(500).json({ error: 'Failed to update campaign', details: error.message });
  }
};

/**
 * Send campaign from Brevo (test send or full send)
 * POST /api/campaign/:campaignId/send
 */
exports.sendCampaign = async (req, res) => {
  try {
    const { campaignId } = req.params;
    const { testEmail } = req.body;

    if (!campaignId) return res.status(400).json({ error: 'Campaign ID is required' });

    const endpoint = testEmail 
      ? `${BREVO_API_URL}/emailCampaigns/${campaignId}/sendTest`
      : `${BREVO_API_URL}/emailCampaigns/${campaignId}/send`;

    const payload = testEmail ? { emailTo: [testEmail] } : {};

    const response = await fetch(endpoint, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(payload),
    });

    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Failed to send campaign: ${errorText}`);
    }

    res.status(200).json({
      success: true,
      message: testEmail ? `Test email sent to ${testEmail}` : 'Campaign sent successfully!',
    });
  } catch (error) {
    console.error('Send campaign error:', error);
    res.status(500).json({ error: 'Failed to send campaign', details: error.message });
  }
};

/**
 * Delete campaign from Brevo
 * DELETE /api/campaign/:campaignId
 */
exports.deleteCampaign = async (req, res) => {
  try {
    const { campaignId } = req.params;
    if (!campaignId) return res.status(400).json({ error: 'Campaign ID is required' });

    const response = await fetch(`${BREVO_API_URL}/emailCampaigns/${campaignId}`, {
      method: 'DELETE',
      headers: getHeaders(),
    });

    if (!response.ok) throw new Error(`Failed to delete campaign: ${response.statusText}`);
    res.status(200).json({ success: true, message: 'Campaign deleted successfully!' });
  } catch (error) {
    console.error('Delete campaign error:', error);
    res.status(500).json({ error: 'Failed to delete campaign', details: error.message });
  }
};