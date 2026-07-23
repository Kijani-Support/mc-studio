import { createRecord, listRecords } from "../../../lib/zite";
import { revalidatePath } from "next/cache";
import { getServerSession } from "next-auth";
import { authOptions } from "../../../lib/auth";

async function uploadResource(formData: FormData) {
  "use server";
  const session = await getServerSession(authOptions);
  await createRecord(process.env.ZITE_TABLE_WEEKLY_RESOURCES!, {
    "Week No": Number(formData.get("week")),
    Phase: formData.get("phase"),
    Pathway: formData.get("pathway"),
    Title: formData.get("title"),
    "Resource Link": formData.get("link"),
    Visibility: formData.get("visibility"),
    "Uploaded By": (session as any)?.user?.name || formData.get("uploadedBy"),
  });
  revalidatePath("/admin/resources");
}

async function getResources() {
  const { records } = await listRecords(
    process.env.ZITE_TABLE_WEEKLY_RESOURCES!
  );
  return records || [];
}

export default async function AdminResources() {
  const resources = await getResources();

  return (
    <main className="min-h-screen bg-gray-50 p-8">
      <div className="mx-auto max-w-4xl">
        <h1 className="mb-2 text-2xl font-bold text-gray-900">
          Upload Weekly Resource
        </h1>
        <p className="mb-6 text-sm text-gray-500">
          New items default to <strong>Draft</strong> — flip to{" "}
          <strong>Published</strong> when ready for students.
        </p>

        <form
          action={uploadResource}
          className="mb-10 rounded-lg border bg-white p-6 shadow-sm"
        >
          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label className="mb-1 block text-sm font-medium text-gray-700">
                Week No
              </label>
              <input
                name="week"
                type="number"
                placeholder="e.g. 4"
                required
                className="w-full rounded border px-3 py-2 text-sm"
              />
            </div>
            <div>
              <label className="mb-1 block text-sm font-medium text-gray-700">
                Phase
              </label>
              <select name="phase" required className="w-full rounded border px-3 py-2 text-sm">
                <option value="p1">Phase 1</option>
                <option value="p2">Phase 2</option>
                <option value="p3">Phase 3</option>
              </select>
            </div>
            <div>
              <label className="mb-1 block text-sm font-medium text-gray-700">
                Pathway
              </label>
              <select name="pathway" required className="w-full rounded border px-3 py-2 text-sm">
                <option value="all">All Pathways</option>
                <option value="bi">Business Intelligence</option>
                <option value="cyber">Cybersecurity</option>
                <option value="ds">Data Science</option>
                <option value="pd">Product Development</option>
              </select>
            </div>
            <div>
              <label className="mb-1 block text-sm font-medium text-gray-700">
                Visibility
              </label>
              <select
                name="visibility"
                defaultValue="draft"
                className="w-full rounded border px-3 py-2 text-sm"
              >
                <option value="draft">Draft (hidden from students)</option>
                <option value="published">Published (visible to students)</option>
              </select>
            </div>
            <div className="sm:col-span-2">
              <label className="mb-1 block text-sm font-medium text-gray-700">
                Resource Title
              </label>
              <input
                name="title"
                placeholder="e.g. Week 4 — Data Modeling Basics"
                required
                className="w-full rounded border px-3 py-2 text-sm"
              />
            </div>
            <div className="sm:col-span-2">
              <label className="mb-1 block text-sm font-medium text-gray-700">
                Resource Link
              </label>
              <input
                name="link"
                type="url"
                placeholder="https://..."
                required
                className="w-full rounded border px-3 py-2 text-sm"
              />
            </div>
          </div>
          <button
            type="submit"
            className="mt-4 rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
          >
            Save Resource
          </button>
        </form>

        <h2 className="mb-3 text-lg font-semibold text-gray-900">
          All Resources
        </h2>
        {resources.length === 0 ? (
          <p className="text-sm text-gray-500">No resources uploaded yet.</p>
        ) : (
          <div className="overflow-hidden rounded-lg border bg-white shadow-sm">
            <table className="w-full text-left text-sm">
              <thead className="border-b bg-gray-50">
                <tr>
                  <th className="px-4 py-2">Week</th>
                  <th className="px-4 py-2">Phase</th>
                  <th className="px-4 py-2">Pathway</th>
                  <th className="px-4 py-2">Title</th>
                  <th className="px-4 py-2">Visibility</th>
                </tr>
              </thead>
              <tbody>
                {resources.map((r: any) => (
                  <tr key={r.id} className="border-b last:border-0">
                    <td className="px-4 py-2">{r.fields["Week No"]}</td>
                    <td className="px-4 py-2">{r.fields.Phase}</td>
                    <td className="px-4 py-2">{r.fields.Pathway}</td>
                    <td className="px-4 py-2">{r.fields.Title}</td>
                    <td className="px-4 py-2">
                      <span
                        className={`rounded-full px-2 py-0.5 text-xs font-medium ${
                          r.fields.Visibility === "published"
                            ? "bg-green-100 text-green-700"
                            : "bg-yellow-100 text-yellow-700"
                        }`}
                      >
                        {r.fields.Visibility}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </main>
  );
}
