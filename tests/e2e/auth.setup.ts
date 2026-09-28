import fs from "node:fs";
import path from "node:path";
import { type Page } from "@playwright/test";
import { test as setup, expect } from "./fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "./utils/login";

/**
 * Fills the login form and confirms both fields hold what was typed.
 * wp-login.php runs focus and show-password scripts after `load`, and a fill
 * racing them has been seen to land in the wrong field (2026-09-24). The
 * check compares values without printing them — a toHaveValue() failure
 * would write the password into the report.
 */
async function fillLoginForm(page: Page, user: string, pass: string) {
  const userField = page.locator("#user_login");
  const passField = page.locator("#user_pass");
  for (let attempt = 1; attempt <= 3; attempt++) {
    await userField.fill(user);
    await passField.fill(pass);
    if (
      (await userField.inputValue()) === user &&
      (await passField.inputValue()) === pass
    ) {
      return;
    }
  }
  throw new Error("login form did not keep the typed credentials after 3 attempts");
}

/**
 * Logs in once through core's wp-login.php form and saves the session for
 * every spec that needs one (see utils/login.ts for why not per spec).
 * Tagged with both tiers because run-suite.mjs filters every project by tier,
 * this one included. Without credentials it writes an empty state, and the
 * specs that need a session skip themselves.
 */
setup("authenticate as admin @fresh @demo", async ({ page }) => {
  fs.mkdirSync(path.dirname(ADMIN_STATE), { recursive: true });
  if (!hasAdminCredentials()) {
    fs.writeFileSync(ADMIN_STATE, JSON.stringify({ cookies: [], origins: [] }));
    return;
  }

  await page.goto("/wp-login.php");
  await page.waitForLoadState("networkidle");
  await fillLoginForm(
    page,
    process.env.TGQA_ADMIN_USER!,
    process.env.TGQA_ADMIN_PASS!,
  );

  // Wait on the path, not a regex over the URL: wp-login.php's own
  // `redirect_to=…/wp-admin/` query would match before login completes.
  await Promise.all([
    page.waitForURL((url) => url.pathname.includes("/wp-admin/")),
    page.locator("#wp-submit").click(),
  ]);
  await expect(page.locator("#wpadminbar")).toBeAttached();

  await page.context().storageState({ path: ADMIN_STATE });
});
