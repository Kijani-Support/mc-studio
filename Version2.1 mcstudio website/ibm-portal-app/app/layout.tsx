import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "MC Studio IBM Curriculum Portal",
  description: "Facilitator and student portal for the IBM SkillsBuild curriculum",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
