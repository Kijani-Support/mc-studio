import { withAuth } from "next-auth/middleware";

// Any signed-in IBM Verify user can hit /student/*; only Role=admin (looked up
// from the Zite Users table in lib/auth.ts session callback) can hit /admin/*.
export default withAuth({
  callbacks: {
    authorized: ({ token, req }) => {
      if (!token) return false;
      if (req.nextUrl.pathname.startsWith("/admin")) return token.role === "admin";
      return true; // any authenticated user for /student/*
    },
  },
});

export const config = { matcher: ["/admin/:path*", "/student/:path*"] };
