import { listPublishedResources } from "../../../lib/zite";

export default async function StudentResources() {
  const { records } = await listPublishedResources();

  return (
    <main className="min-h-screen bg-gray-50 p-8">
      <div className="mx-auto max-w-3xl">
        <h1 className="mb-2 text-2xl font-bold text-gray-900">
          Weekly Resources
        </h1>
        <p className="mb-6 text-sm text-gray-500">
          Published materials from your facilitators.
        </p>

        {!records || records.length === 0 ? (
          <div className="rounded-lg border bg-white p-8 text-center shadow-sm">
            <p className="text-gray-500">
              No resources published yet — check back soon.
            </p>
          </div>
        ) : (
          <div className="space-y-3">
            {records.map((r: any) => (
              <div
                key={r.id}
                className="flex items-center justify-between rounded-lg border bg-white p-4 shadow-sm"
              >
                <div>
                  <span className="text-xs font-medium text-gray-400">
                    Week {r.fields["Week No"]} &middot; {r.fields.Phase} &middot;{" "}
                    {r.fields.Pathway}
                  </span>
                  <h2 className="text-sm font-semibold text-gray-900">
                    {r.fields.Title}
                  </h2>
                </div>
                <a
                  href={r.fields["Resource Link"]}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="shrink-0 rounded bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700"
                >
                  Open
                </a>
              </div>
            ))}
          </div>
        )}
      </div>
    </main>
  );
}
