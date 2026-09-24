import path from "node:path";

/**
 * Storage state for a logged-in admin, written once per run by
 * tests/e2e/auth.setup.ts. Specs that need a session use
 * `test.use({ storageState: ADMIN_STATE })` instead of logging in themselves:
 * WordPress keeps a user's sessions in one `session_tokens` user meta, and
 * parallel logins as the same user race on it — the loser's token is
 * dropped and its next request is silently logged out.
 */
export const ADMIN_STATE = path.join(__dirname, "..", ".auth", "admin.json");

export const hasAdminCredentials = (): boolean =>
  !!process.env.TGQA_ADMIN_USER && !!process.env.TGQA_ADMIN_PASS;
