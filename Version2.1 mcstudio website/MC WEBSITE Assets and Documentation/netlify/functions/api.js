const express = require('express');
const serverless = require('serverless-http');
const cors = require('cors');

// Import the whole module first
const brevoController = require('../../server/api/brevoController');

// Safely extract the functions, accounting for bundler quirks
const subscribeToNewsletter = brevoController.subscribeToNewsletter || (brevoController.default && brevoController.default.subscribeToNewsletter);
const handleContactForm = brevoController.handleContactForm || (brevoController.default && brevoController.default.handleContactForm);

const app = express();
app.use(cors());
app.use(express.json());

const router = express.Router();

// A simple test route to verify the API is successfully booting
router.get('/status', (req, res) => res.json({ status: 'API is online!' }));

// Defensive routing: Only attach routes if the functions successfully imported
if (typeof subscribeToNewsletter === 'function') {
  router.post('/subscribe', subscribeToNewsletter);
} else {
  console.error('CRITICAL: subscribeToNewsletter failed to import.');
}

if (typeof handleContactForm === 'function') {
  router.post('/contact', handleContactForm);
} else {
  console.error('CRITICAL: handleContactForm failed to import.');
}

app.use('/.netlify/functions/api', router);

module.exports.handler = serverless(app);