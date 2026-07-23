import Link from "next/link";

export default function Home() {
  return (
    <main className="flex min-h-screen flex-col items-center justify-center gap-6 p-8">
      <h1 className="text-3xl font-bold">MC Studio IBM Curriculum Portal</h1>
      <p className="text-gray-600 max-w-md text-center">
        Access weekly resources, track your pathway progress, and stay on top of
        your IBM SkillsBuild curriculum.
      </p>
      <div className="flex gap-4">
        <Link
          href="/student/resources"
          className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
        >
          Student Resources
        </Link>
        <Link
          href="/admin/resources"
          className="rounded bg-gray-800 px-4 py-2 text-white hover:bg-gray-900"
        >
          Admin Panel
        </Link>
      </div>
    </main>
  );
}
