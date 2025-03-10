<p align="center"><img src="/public/storage/logo.png" alt="Drongo Logo" style="width: 250px"/></p>


# Drongo
Drongo is an innovative employee attendance management system that uses facial recognition and comparison to authenticate and record employee attendance. Inspired by the drongo bird, which acts as a security watchman for other animals, this application ensures accurate and secure attendance tracking.

<div align="center"><img src="/public/storage/drongo.jpg"/></div>

## Features

- **Facial Recognition**: Utilizes advanced facial recognition technology to authenticate employee attendance.
- **Attendance Comparison**: Compares facial data to ensure the correct employee is marked present.
- **Attendance Ranking**: Ranks employees based on their punctuality, highlighting the most punctual employees.
- **Secure and Accurate**: Ensures secure and accurate attendance tracking, reducing the chances of fraudulent attendance marking.

## Tools and Technologies

- **Facial Recognition API**: Used for detecting and recognizing faces.
- **Backend Framework**: Laravel for building the server-side application.
- **Database**: MySQL for storing employee data and attendance records.
- **Communication**: Utilized Inertia.js for seamless communication between the frontend and backend.
- **Frontend Framework**: Vue.js for building the user interface.
- **Authentication**: Laravel Passport for secure authentication.

## Project Stack

- **Frontend**: Vue.js, Inertia.js Tailwind CSS,  JavaScript
- **Backend**: Laravel
- **Database**: MySQL
- **Authentication**: Laravel Passport
- **Facial Recognition API**: Face++

## Installation and Setup

1. **Clone the repository**:
    ```bash
    git clone https://github.com/nduagoziem/drongo.git
    cd drongo
    ```

2. **Install dependencies**:
    ```bash
    composer install
    npm install
    ```

3. **Set up environment variables**:
    Create a `.env` file in the root directory and add the necessary environment variables.

4. **Run the application**:
    ```bash
    php artisan migrate
    php artisan serve
    npm run dev
    ```

## Usage

1. **Register Employees**: Add employee details and capture their facial data.
2. **Authenticate Attendance**: Employees can authenticate their attendance using facial recognition.
3. **View Attendance Records**: Admins can view and manage attendance records.
4. **Attendance Ranking**: View the ranking of employees based on their punctuality and lateness.

## Contributing

We welcome contributions to Drongo! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch.
3. Make your changes and commit them.
4. Push to the branch.
5. Create a pull request.

<!-- ## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details. -->
