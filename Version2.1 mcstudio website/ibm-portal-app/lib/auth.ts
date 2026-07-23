import type { NextAuthOptions } from "next-auth";
import { listRecords } from "./zite";

// IBM Verify as a generic OIDC provider. IBM Verify's public app URL for this
// project should be registered as the redirect URI:
//   <NEXTAUTH_URL>/api/auth/callback/ibm-verify
export const authOptions: NextAuthOptions = {
  providers: [
    {
      id: "ibm-verify",
      name: "IBM Verify",
      type: "oauth",
      wellKnown: `${process.env.IBM_VERIFY_ISSUER}/.well-known/openid-configuration`,
      clientId: process.env.IBM_VERIFY_CLIENT_ID,
      clientSecret: process.env.IBM_VERIFY_CLIENT_SECRET,
      authorization: { params: { scope: "openid email profile" } },
      idToken: true,
      checks: ["pkce", "state"],
      profile(profile) {
        return { id: profile.sub, name: profile.name, email: profile.email };
      },
    },
  ],
  callbacks: {
    // Look up the signed-in email in Zite's Users table and attach Role/Pathway
    // to the session so pages/middleware can gate on it.
    async session({ session }) {
      const email = session.user?.email;
      if (!email) return session;
      // Fetch all users and match by email in JS — safer than URL-encoding
      // the email into Zite's filter syntax, which breaks on @ and + chars.
      const { records } = await listRecords(process.env.ZITE_TABLE_USERS!);
      const user = records?.find(
        (r: any) =>
          r.fields?.Email?.toLowerCase() === email.toLowerCase()
      );
      (session as any).role = user?.fields?.Role ?? "student";
      (session as any).pathway = user?.fields?.Pathway ?? null;
      return session;
    },
  },
};
