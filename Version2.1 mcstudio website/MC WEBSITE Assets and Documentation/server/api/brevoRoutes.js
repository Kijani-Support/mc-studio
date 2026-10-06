const express = require('express');
const { subscribeToNewsletter, handleContactForm } = require('./brevoController.js');
const {
  getCampaign,
  updateCampaign,
  sendCampaign,
  deleteCampaign,
  getAllCampaigns,
} = require('./campaignController.js');

const router = express.Router();

/**
 * Newsletter subscription route
 * POST /api/subscribe
 * Body: { email: string, firstName?: string }
 */
router.post('/subscribe', subscribeToNewsletter);

/**
 * Contact form submission route
 * POST /api/contact
 * Body: { firstName: string, lastName: string, email: string, phone?: string, subject: string, message: string }
 */
router.post('/contact', handleContactForm);

/**
 * Campaign Management Routes (fetch from Brevo)
 */

// Get all campaigns from Brevo
// GET /api/campaigns?limit=50&offset=0&status=sent
router.get('/campaigns', getAllCampaigns);

// Get specific campaign from Brevo
// GET /api/campaign/:campaignId
router.get('/campaign/:campaignId', getCampaign);

// Update campaign in Brevo (modify before sending)
// PUT /api/campaign/:campaignId
router.put('/campaign/:campaignId', updateCampaign);

// Send campaign (full send or test)
// POST /api/campaign/:campaignId/send
router.post('/campaign/:campaignId/send', sendCampaign);

// Delete campaign from Brevo
// DELETE /api/campaign/:campaignId
router.delete('/campaign/:campaignId', deleteCampaign);

module.exports = router;