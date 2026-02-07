<br>
<br>
<p align="center">
<a href="https://github.com/sayaka04/laravel-ai-image-sorter"><img src="https://img.shields.io/badge/SmartSorterAI-Sayaka04-ff0055?style=flat-pill" alt="Build Status" style="height:70px"></a>
</p>

<h3 align="center">Automated Image Sorting with Local Vision Models.</h3>

<p align="center">
<a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel"></a>
<a href="https://tailwindcss."><img src="https://img.shields.io/badge/Tailwind_CSS-3.4.17-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind"></a>
<a href="https://ollama.com"><img src="https://img.shields.io/badge/AI-Ollama-blue?style=for-the-badge" alt="Ollma"></a>
</p>


SmartSorter AI is a local-first Digital Asset Management (DAM) system designed to automate file organization.

SmartSorter organizes unstructured images (screenshots, receipts, references) using a two-stage local AI pipeline. Instead of applying generic auto-tags, it sorts files based on specific rules defined by the user. All processing happens locally on the host machine, removing the need for external cloud APIs.

---

## 🏗 System Architecture

The core functionality relies on separating **Visual Perception** from **Logical Reasoning**. A single multimodal model often struggles to classify images into arbitrary, user-specific folders. SmartSorter AI solves this via a two-stage pipeline processed asynchronously via Laravel Queues.

### The Dual-Model Pipeline

1. **Phase 1: The Observer (Vision Extraction)**
* **Input:** Raw Image Blob.
* **Process:** The system passes the image to a Vision-Language Model (VLM) via Ollama.
* **Output:** A verbose textual description of the image, including OCR data, texture analysis, and object detection. No decision is made at this stage; the goal is pure data extraction.


2. **Phase 2: The Judge (Semantic Reasoning)**
* **Input:** The textual description from Phase 1 + User-defined sorting rules (e.g., *"If the receipt is for hardware, put in Expense/Hardware"*).
* **Process:** A lightweight reasoning model evaluates the textual data against the logic constraints.
* **Output:** A deterministic folder assignment.



---


## ⚡ Technical Features

* **Asynchronous Inference:** Image processing is computationally expensive. All uploads are dispatched to `database` queues, preventing HTTP timeouts and allowing for batch processing of heavy workloads.
* **Data Sovereignty & Isolation:** Files are stored on a private disk using Laravel's storage abstraction. Access is strictly scoped to `Auth::user()->id()`, preventing cross-user data leakage.
* **Resource Management:** Includes a configurable storage quota system (default: 200MB per user) to manage disk usage in multi-user environments.
* **Contextual Export:** Generates structured ZIP archives on the fly, mirroring the sorted directory structure.

---

## 🛠 Technology Stack

| Component | Technology | Description |
| --- | --- | --- |
| **Framework** | Laravel 12 (PHP 8.2) | Core MVC and Queue Management |
| **Inference** | Ollama API | Local LLM/VLM orchestration |
| **Database** | MySQL | Relational data and Job tables |
| **Frontend** | Tailwind CSS | Utility-first styling (Slate/Neon palette) |
| **Workers** | Laravel Queue | Background process management |

---

## 🧠 Workflow Logic

The application enforces a **Definition-First** approach to ensure sorting accuracy:

1. **Create Album:** Initialize a project container (e.g., "March Screenshots").
2. **Define Rules:** Create destination folders and assign logic prompts *before* uploading.
* *Example:* Category `Errors` → Rule: *"Screenshots containing stack traces or red console text."*


3. **Upload:** Batch upload images (`JPG`, `PNG`, `WEBP`). The system stores the raw files and dispatches jobs to the `vision` queue.
4. **Background Processing:**
* **Step A:** The **Observer** job picks up the image and generates a text description.
* **Step B:** The **Judge** job picks up the description and matches it against the rules defined in Step 2.


5. **Validation & Export:** Review the "AI Reasoning" logs to verify the sorting logic, then download the organized structure as a ZIP.

---

## 🔧 Installation & Setup

### Prerequisites

* PHP 8.2+
* Composer
* Node.js & NPM
* [Ollama](https://ollama.com) (Running locally)

### Step-by-Step

1. **Clone the repository**
```bash
git clone https://github.com/sayaka04/laravel-ai-image-sorter.git
cd smartsorter-ai

```


2. **Install dependencies**
```bash
composer install
npm install && npm run build

```


3. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate

```

4. **Run Migrations:**
```bash
php artisan migrate

```

5. **Local AI Setup (Ollama):**
Ensure [Ollama](https://ollama.com) is running locally with your preferred vision model.
```bash
ollama serve

```

6. **Run Workers:**
```bash
php artisan queue:work --queue="vision"
php artisan queue:work --queue="text"

```

7. **Run Serve:**
```bash
php artisan serve

```

---

## 🛡️ Security

**Storage Access:** Utilizes Laravel's `Storage::disk('private')` driver. Direct file access is blocked; all assets are served via signed URLs or authenticated controller methods.

## 👤 Author

**Sayaka04**

---

