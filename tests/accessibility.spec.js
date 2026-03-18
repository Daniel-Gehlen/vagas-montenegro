import { test } from '@playwright/test';
import { injectAxe, checkA11y } from '@axe-core/playwright';

test.describe('Acessibilidade', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('http://localhost:8080');
    await injectAxe(page);
  });

  test('sem violações WCAG', async ({ page }) => {
    await checkA11y(page, null, {
      detailedReport: true,
      detailedReportOptions: { outputDir: 'reports/accessibility' }
    });
  });

  test('hierarquia de headings', async ({ page }) => {
    const h1 = await page.locator('h1').textContent();
    expect(h1).toContain('Vagas Montenegro');
  });

  test('navegação por teclado', async ({ page }) => {
    await page.keyboard.press('Tab');
    const focus = await page.locator(':focus').isVisible();
    expect(focus).toBe(true);
  });
});
