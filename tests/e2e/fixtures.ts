import { test as base, expect, type Page } from "@playwright/test";

/**
 * Every spec imports `test` from here, not from @playwright/test.
 *
 * CI boots WordPress Playground with `--login`, whose mu-plugin logs in any
 * visitor that does not carry the `playground_auto_login_already_happened`
 * cookie. Without it every "logged-out" spec actually runs as admin, with the
 * admin bar over the page (seen on PR #56). Setting the cookie on each context
 * makes a fresh context anonymous on Playground and is ignored everywhere
 * else. Specs that need a session still load ADMIN_STATE on top of it.
 */
export const test = base.extend({
  context: async ({ context, baseURL }, use) => {
    await context.addCookies([
      {
        name: "playground_auto_login_already_happened",
        value: "1",
        domain: new URL(baseURL!).hostname,
        path: "/",
      },
    ]);
    await use(context);
  },
});

/** Fails legibly, instead of timing out later, if the visitor is logged in. */
export async function expectLoggedOut(page: Page): Promise<void> {
  await expect(
    page.locator("#wpadminbar"),
    "this spec expects an anonymous visitor, but the admin bar is present",
  ).toHaveCount(0);
}

export { expect };
