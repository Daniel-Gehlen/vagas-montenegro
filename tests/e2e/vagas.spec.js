import { test, expect } from '@playwright/test';

test.describe('Vagas Application', () => {
  test('should load the main page', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('h1')).toContainText('Vagas de Emprego');
  });

  test('should display job listings', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('.job-list')).toBeVisible();
  });

  test('should filter jobs by search term', async ({ page }) => {
    await page.goto('/');
    await page.fill('#search-input', 'Desenvolvedor');
    await page.click('#search-btn');
    await expect(page.locator('.job-item')).toHaveCountGreaterThan(0);
  });

  test('should create a new job posting', async ({ page }) => {
    await page.goto('/');
    await page.click('#add-job-btn');
    await page.fill('#job-title', 'Desenvolvedor Frontend');
    await page.fill('#job-company', 'Empresa Teste');
    await page.fill('#job-description', 'Vaga de desenvolvedor frontend');
    await page.click('#save-job-btn');
    await expect(page.locator('.success-message')).toBeVisible();
  });
});
