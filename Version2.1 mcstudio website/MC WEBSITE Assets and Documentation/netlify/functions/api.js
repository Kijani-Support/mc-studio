const express = require('express');
const serverless = require('serverless-http');
const cors = require('cors');

// Import your existing logic
const brevoRoutes = require('Version2.1 mcstudio website/MC WEBSITE Assets and Documentation/server/api/brevoRoutes');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Link your routes
// This makes them accessible at /.netlify/functions/api/brevo/...
app.use('/.netlify/functions/api', brevoRoutes);

module.exports.handler = serverless(app);
