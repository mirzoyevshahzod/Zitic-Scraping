<p align="center">
<a href="https://zitic.ru/eo/vl/" target="_blank">
<img src="https://upload.wikimedia.org/wikipedia/commons/f/f3/Flag_of_Russia.svg" width="200" alt="Zitic Logo">
</a>
</p>

<p align="center">
<b>Zitic Scraping</b>
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/PHP-8.x-blue" alt="PHP"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-Framework-red" alt="Laravel"></a>
<a href="#"><img src="https://img.shields.io/badge/Selenium-WebDriver-green" alt="Selenium"></a>
<a href="#"><img src="https://img.shields.io/badge/Export-Excel-success" alt="Excel"></a>
<a href="#"><img src="https://img.shields.io/badge/License-MIT-lightgrey" alt="License"></a>
</p>

---

## About Project

**Zitic Scraping** — bu loyiha :contentReference[oaicite:0]{index=0} saytida mavjud bo‘lgan avtomobillar navbatini scraping qiladi.

Loyiha quyidagilarni bajaradi:

- Saytdagi barcha mashinalarni yig‘adi  
- Faqat **O‘zbekiston davlat raqamiga ega avtomobillarni** filtrlaydi  
- Har bir mashinani **zanjir (local database)** dan qidiradi  
- Company ma’lumotini Excelga qo‘shadi  
- Frontend orqali boshqariladi  

---

## Features

- 🇺🇿 Uzbek car detection (regex orqali) :contentReference[oaicite:1]{index=1}  
- 📊 Excel export  
- 🤖 Selenium orqali dynamic scraping  
- 🧠 DB integration (company name olish)  
- 🖥 Frontend orqali boshqarish  
- ⚡ Large data handling (50+ rows kutish optimizatsiyasi bor)  

---

## Tech Stack

- Laravel (PHP)
- Selenium WebDriver
- ChromeDriver
- PhpSpreadsheet
- MySQL

---

## Installation

```bash
git clone https://github.com/your-username/zitic-scraping.git
cd zitic-scraping
composer install
cp .env.example .env
php artisan key:generate
