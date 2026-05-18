import fs from 'node:fs';
import path from 'node:path';
import { test, expect } from '@playwright/test';

test('login and logout', async ({ page }) => {
  const screenshotDir = path.join('test-results', 'screenshots');
  fs.mkdirSync(screenshotDir, { recursive: true });

  await page.goto('http://127.0.0.1:8000/login');
  await page.getByRole('textbox', { name: 'Masukkan email Anda' }).click();
  await page.getByRole('textbox', { name: 'Masukkan email Anda' }).click();
  await page.getByRole('textbox', { name: 'Masukkan email Anda' }).click();
  await page.getByRole('textbox', { name: 'Masukkan email Anda' }).fill('ownerbakery3@gmail.com');
  await page.getByRole('textbox', { name: 'Kata Sandi' }).click();
  await page.getByRole('textbox', { name: 'Kata Sandi' }).fill('owner123');
  await page.getByRole('button', { name: 'Masuk' }).click();

  await expect(page.getByRole('button', { name: 'AD' })).toBeVisible();
  await page.screenshot({ path: path.join(screenshotDir, 'login.png'), fullPage: true });

  await page.getByRole('button', { name: 'AD' }).click();
  await page.getByRole('button', { name: ' Logout' }).click();

  await expect(page.getByRole('button', { name: 'Masuk' })).toBeVisible();
  await page.screenshot({ path: path.join(screenshotDir, 'logout.png'), fullPage: true });
});