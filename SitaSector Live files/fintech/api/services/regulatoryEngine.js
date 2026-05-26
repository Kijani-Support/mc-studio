const { transformToCMA } = require('../../pipelines/cma_transform');

function applyRegulatorSchema(regulator, rows) {
  if (regulator === 'CMA') return transformToCMA(rows);
  return rows;
}

module.exports = { applyRegulatorSchema };
