// Thin server-side client for the Zite DB REST API.
// Docs: https://www.zite.com/help/database/api/database-api
// NOTE: verify exact sub-paths against your account's live API reference
// (Developer settings tab) before first deploy — Zite documents endpoints
// per-action rather than a single OpenAPI spec at time of writing.

const BASE = process.env.ZITE_BASE_URL!;
const DB = process.env.ZITE_DATABASE_ID!;
const KEY = process.env.ZITE_API_KEY!;

async function zite(path: string, init: RequestInit = {}) {
  const res = await fetch(`${BASE}/databases/${DB}${path}`, {
    ...init,
    headers: {
      Authorization: `Bearer ${KEY}`,
      "Content-Type": "application/json",
      ...(init.headers || {}),
    },
    cache: "no-store",
  });
  if (!res.ok) throw new Error(`Zite API ${res.status}: ${await res.text()}`);
  return res.json();
}

export const listRecords = (tableId: string, params = "") =>
  zite(`/tables/${tableId}/records${params}`);

export const createRecord = (tableId: string, fields: Record<string, unknown>) =>
  zite(`/tables/${tableId}/records`, { method: "POST", body: JSON.stringify({ fields }) });

export const updateRecord = (tableId: string, recordId: string, fields: Record<string, unknown>) =>
  zite(`/tables/${tableId}/records/${recordId}`, { method: "PATCH", body: JSON.stringify({ fields }) });

// Convenience: only "published" weekly resources — the student-facing gate.
export const listPublishedResources = () =>
  listRecords(process.env.ZITE_TABLE_WEEKLY_RESOURCES!, `?filter=Visibility:published`);
