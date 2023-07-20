# KPI Visualizer - Simple and fun project to show KPIs on company TV

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)

## Introduction

KPI Reporter is a PHP-based dynamic dashboard that allows you to track and visualize key performance indicators (KPIs) for your business. It fetches KPI data from a JSON file and presents it in a beautiful and interactive web page using Blade templating system and Chart.js for stunning charts.

The dashboard categorizes different metrics and displays them in separate columns, making it easy to keep track of your business's progress over time. It also supports multi-item metrics with data from different dates.

## Features

- Clean and well-organized PHP codebase with clean architecture.
- Utilizes design patterns for maintainability and scalability.
- Integrates Blade template system for efficient HTML rendering.
- Displays KPI data in a cute and user-friendly HTML web page.
- Uses Chart.js to visualize KPI progress with beautiful line charts.
- Supports date formatting for varient calendar type such as Gregorian and Jalali (Persian) calendars.

## Installation

1. Clone this repository to your local machine.
2. Make sure you have PHP and a web server (e.g., Apache, Nginx) installed.
3. Copy `.env_example` as `.env` file in the root directory and set your `CompanyName` and `LocaleDateString`.
4. Create a `kpi_data.json` file in the root directory and add your KPI data like usage.
5. Run the project using the web server of your choice.

## Usage

1. Run php scripts with `php -S localhost:8000`
2. Access the dashboard through your web server (e.g., http://localhost:8000).
3. Change `kpi_data.json` like the example below :
```
[
    {
        "metric": "customer_count",
        "measurement_day": "2023-07-19",
        "value": 220
    },
    {
        "metric": "saas_income",
        "measurement_day": "2023-07-19",
        "value": 500000000
    },
]
```

## Technologies Used

- PHP with clean and well-architected code.
- Blade template engine for efficient and clean HTML rendering.
- Chart.js for beautiful and interactive line charts.
- JSON data storage for KPIs in `kpi_data.json`.
- XAMPP or any web server with PHP support for local development.

## Contributing

Contributions to this project are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or submit a pull request. Let's build an even more exciting and powerful KPI dashboard together!

## License

This project is licensed under the [MIT License](LICENSE).

