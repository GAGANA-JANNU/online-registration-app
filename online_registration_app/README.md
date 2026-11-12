# Online Student Registration Web Application

A beginner-friendly registration form built with HTML, CSS, JavaScript, jQuery and PHP.

## Features
- Responsive registration form
- jQuery client-side validation
- PHP server-side validation
- Escaped output to reduce cross-site scripting (XSS) risk
- Formatted success/receipt page after submission
- Print application button
- Render deployment configuration using Docker

## Run locally
1. Install PHP 8.2 or later.
2. Open a terminal in this project folder.
3. Run:

   ```bash
   php -S localhost:8000 -t public
   ```

4. Open http://localhost:8000 in your browser.

## Deploy to Render
1. Create a GitHub repository and upload all project files (keep `Dockerfile` and `render.yaml` in the repository root).
2. Sign in to Render and choose **New + → Blueprint**.
3. Connect the GitHub repository.
4. Render detects `render.yaml`; review and create the web service.
5. Wait for deployment, then open the generated `onrender.com` URL.

You can also create a **New Web Service** and select the Docker runtime if you prefer manual setup.

## Important notes
- This is an educational demonstration. It validates and displays submitted details but does not save registrations to a database or send confirmation emails.
- Do not collect real student personal data on this demo deployment. For production, add HTTPS, a database, CSRF protection, privacy/retention controls, stronger validation, and access controls.
- jQuery is loaded from the official jQuery CDN, so client-side validation needs an internet connection. PHP validation still works without it.
