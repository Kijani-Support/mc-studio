async function sendPersonalizedEmail({ email, template, payload }) {
  console.log(`[Email] ${template} → ${email}`, payload);
  return { sent: true, messageId: `msg-${Date.now()}` };
}

module.exports = { sendPersonalizedEmail };
