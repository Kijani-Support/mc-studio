const express = require('express');
const serverless = require('serverless-http');
const cors = require('cors');

// 1. Destructure the specific functions from your controller
const { subscribeToNewsletter, handleContactForm } = require('../../server/api/brevoController');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// 2. Create an explicit Express Router
const router = express.Router();

// 3. Define the POST routes and attach your controller functions
router.post('/subscribe', subscribeToNewsletter);
router.post('/contact', handleContactForm);

// 4. Mount the router at the Netlify function path
app.use('/.netlify/functions/api', router);

module.exports.handler = serverless(app);