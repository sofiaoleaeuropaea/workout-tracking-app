# Backend project: Ironclad Gym Tracker

Ironclad Gym Tracker is an MVC-based application designed to help users manage their fitness journeys. Key features include:

- Workout Management: Users can easily add, update, and delete workouts, providing a comprehensive workout tracking experience.
- Exercise Scheduling: A built-in calendar allows users to schedule their exercises, helping them stay organized and committed to their fitness goals.
- User Account Management: Users can update their account details for a personalized experience.
- Support Functionality: Users can submit questions to the Ironclad Support Team for assistance.

Admin Features:

- User Management: Admins can view a complete list of users, with the ability to edit or remove accounts as needed.
- Workout Library: Admins can add new exercises to the database or edit existing ones, ensuring the exercise library is always up to date.
- Support Management: A dedicated support page allows admins to view and respond to user inquiries efficiently.

## Features implemented

- Session Management: Utilize the $\_SESSION global to manage admin and user sessions.
- CRUD Functionality: Implement Create, Read, Update, and Delete operations for both user and admin sections.
- Backend Pagination: Employ pagination in the workout library to efficiently manage and display exercises.
- AJAX Implementations:
  - Delete user accounts
  - Remove workouts
  - Create new workout trackers based on plans and view details of existing trackers
- Profile Management: Enable photo uploads during profile creation and editing, with automatic removal of the old photo path when a new image is uploaded
- User Support: Use PHPMailer to respond to user's questions.
- Security Features: Implement CSRF tokens to secure form submissions in PHPMailer.
- Workout Calendar: Provide a calendar view to display scheduled and completed workouts.

## Technologies Used

- PHP: Backend development and server-side logic
- HTML: Structure and content of web pages
- JavaScript: Interactive functionality and dynamic content
- CSS: Styling and layout design for a responsive UI
- Composer: Dependency management for PHP packages
- MySQL: Database management and data storage

### Dependencies used

- PHPMailer: For handling email notifications and sending emails from the server.
- FullCalendar: For creating interactive and customizable calendar views useful for scheduling workouts or tracking events.

## Next Steps

- Enhance UX/UI: This was a purely backend project. One of the top priorities is to create and improve the user experience and interface design to make navigation and interactions more intuitive and visually appealing. Prioritize responsiveness for a smooth user experience on all devices, add search functionalities, and optimize layouts.

- Integrate New Features: Implement biometric tracking for users to monitor their weight and body fat, allowing for a more personalized fitness journey. Enable users to mark exercises as completed, and add a comprehensive exercise library with detailed descriptions of each exercise.

- Integrate Additional Backend Services: Implement CSRF tokens to secure form submissions, set up email notifications to remind users of upcoming workouts, and incorporate PHP-RBAC for robust role-based access control.
