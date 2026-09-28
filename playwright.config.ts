import { defineConfig, devices } from "@playwright/test";

/**
 * TGQA_BASE_URL / TGQA_ADMIN_USER / TGQA_ADMIN_PASS are set by claudegrill's
 * run-suite.mjs before invoking this config. See .themegrill-qa/knowledge.md
 * for what Flash's specs assume about the site under test.
 */
export default defineConfig({
  testDir: "./tests/e2e/specs",
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 1 : 0,
  reporter: [["list"], ["json", { outputFile: "test-results/results.json" }]],
  use: {
    baseURL: process.env.TGQA_BASE_URL,
    trace: "on-first-retry",
  },
  projects: [
    { name: "setup", testDir: "./tests/e2e", testMatch: /auth\.setup\.ts/ },
    {
      name: "chromium",
      use: { ...devices["Desktop Chrome"] },
      dependencies: ["setup"],
    },
  ],
});
