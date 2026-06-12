## Cosmik - Student Academic Study Group Finder

**Course:** BIIT 2305: Web Application Development

**Section:** 2

**Group:** Cosmik

**Lecturer:** Nor Azura Binti Kamarulzaman

**Submission Date:** 11.6.2026

## Group Members & Task Distribution

**Aiman Danish bin Rohaizam (2410177)** - Member 1: Authentication & Profile Management

- **Grading Focus:** User Authentication, DB Schema Modifications, Profile Views.
- **Responsibilities:** Set up Laravel Breeze, customized user schema for matric numbers/expertise, designed auth UI, and built the Profile management subsystem.

**Muhammad Nur Adam Fitri bin Ali (2417235)** - Member 2: Study Group CRUD Operations

- **Grading Focus:** Core Routes, Controllers, Models, and Server-Side Form Validation.
- **Responsibilities:** Created study group migrations, configured the CRUD controller flow, and set up strict rules (e.g., preventing past-dated sessions).

**Ahmad Zahril Fitri bin Ahmad Syukri (2411207)** - Member 3: Dashboard & Advanced Group Search

- **Grading Focus:** Views, Navigation Links, Query Scopes, and Interactive UI Loops.
- **Responsibilities:** Developed multi-attribute search queries, designed the core landing dashboards, and created scope states for joined vs. led groups.

**Ahmad Nur Adam bin Ahmad Jais (2414137)** - Member 4: Request & Approval System

- **Grading Focus:** Pivot Models, Many-to-Many Relationships, and Interactive Approvals.
- **Responsibilities:** Designed join-request workflows, created database mappings for approvals, and implemented real-time approval modals for group leaders.

**Mohamad Arfan bin Mohd Adnan (2414155)** - Member 5: Media & Resource Repository

- **Grading Focus:** Media Utilities, Laravel File Storage System, and Folder Interfaces.
- **Responsibilities:** Configured local file disks, validated media stream formats, and engineered the document upload vaults inside group workspaces.

## Project Overview

Student Academic Study Group Finder is a centralized, web-based study network designed to enhance collaborative peer learning within the student community. In rigorous academic environments, students often face challenges finding partners with aligned study goals or finding classmates in specialized modules (such as Artificial Intelligence, Network Security, or Data Structures).

Developed under the *Laravel Model-View-Controller (MVC) architecture*, Our group bridges this gap. It allows student learners to discover peer circles filtered by subject code, coordinate study times, share reference slides, and submit academic requests all structured within a secure, responsive environment.

## Project Objectives

1. **Collaborative Discovery:** Provide a unified web interface for finding peer study circles based on course codes, exam timelines, and target knowledge areas.

2. **Interactive Access Control:** Ensure safe peer-to-peer administrative boundaries where group leaders retain full control over who enters their study groups.

3. **Media-Rich Repository:** Build an asset vault within each group space so members can share slides, PDFs, notes, and visual study diagrams.

4. **Shariah-Compliance & Ethics:** Establish an ethical, student-only environment that respects academic integrity and community guidelines, avoiding unauthorized resource distribution while promoting constructive peer tutoring.

5. **Technical Mastery:** Demonstrate full stack development principles using Laravel's routing engine, Eloquent ORM relationships, customized Breeze configurations, and asset compilation with Vite.

## Target Users

- **Student Learners:** Individuals searching for, requesting to join, and collaborating within study groups to clarify difficult concepts.

- **Group Leaders:** Admins who organize review modules, review pending applicant profiles, manage membership approvals, and moderate uploaded files.

- **Course Evaluators:** Lecturers and reviewers monitoring active student participation and evaluating technical implementation.

## Features and Functionalities

**User Authentication & Profiles (Member 1)**

- **Matric-Verified Signups:** Registration flow requiring a unique Student Matric Number and specialized Expertise Area to keep out unauthorized web visitors.
- **Profile Workspaces:** An interactive panel where users can review their details, modify their areas of study, and keep academic credentials updated.

**Study Group CRUD Engine (Member 2)**

- **Group Creation UI:** Intuitive forms for creating study sessions, selecting subject codes, and setting titles, descriptions, and venues.
- **Data Verification:** Active form validators that reject past dates, sanitize text inputs, and prevent redundant subject codes.

**Search, Filter & Discover Dashboard (Member 3)**

- **Multi-Attribute Search:** Instant query filtering across titles, specific course codes, or scheduled session dates.
- **Dynamic Dashboards:** Segmented views isolating groups that a student leads from those they have successfully joined.

**Request, Membership & Approval Actions (Member 4)**

- **Join Request Modal:** An interactive pop-up where candidates can submit request applications explaining their learning motivation.
- **Approval Workspace:** A real-time pending interface allowing leaders to review applicants' profiles and accept or decline their requests.

**Media & Resource Vault (Member 5)**

- **Validated File Upload:** Interactive drops for PDFs, cheat sheets, and images, ensuring file size limits and extension filters are applied.
- **Media Render Panel:** Direct browser previewing for images alongside organized list tables for downloading document assets.

## Technical Implementation

### Technology Stack

- Backend Framework: Laravel v11.x (PHP v8.2+)
- Frontend Architecture: Blade Templates, Tailwind CSS (utilizing Vite asset compiler)
- Database Engine: MySQL v8.0 (configured via local XAMPP environment)
- Authentication Scaffold: Laravel Breeze (Custom Migration Setup)
- Asset Storage: Laravel Local File Storage (Symlinked via *php storage:link*)

## Database Design & Schema

Our schema is designed to enforce secure database integrity while handling relational states across users, listings, many-to-many memberships, requests, and shared resources.

**Core Tables**

- **users:** Manages registration details, security passwords, matric codes, and academic profiles.
- **study_groups:** Stores titles, descriptions, subject codes, meeting times, and references to the creating group leader.
- **join_requests:** Stores pending request letters, motivation notes, and approval states linking prospective members to groups.
- **group_members (Pivot Table):** Connects users to groups to build the secure Many-to-Many membership schema.
- **study_resources:** Tracks path keys, original titles, file types, and group IDs of uploaded files.

### Entity Relationship Diagram (ERD) & Key Relationships
Click the link to view our group's ERD:
https://drive.google.com/drive/folders/15e5wQnqJVGiaoi9lrNEJHI19GuMFPblT?usp=sharing

### Key Relationships:
- Users & Study Groups (Created): One-to-Many ($1 \rightarrow N$)
*A single user can create and host multiple study groups.*

- Users & Study Groups (Joined): Many-to-Many ($M \rightarrow N$)
*A student can join multiple study groups, and a study group can contain multiple members through the group_members pivot table.*

- Study Groups & Join Requests: One-to-Many ($1 \rightarrow N$)
A *A study group can receive multiple join requests from various users.*

- Study Groups & Study Resources: One-to-Many ($1 \rightarrow N$)
*A single study group contains a list of uploaded resource files.*

## Laravel Components Implementation

### 1. Web Routes (routes/web.php)

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

// Public Landing Interface
Route::get('/', function () { return view('welcome'); });

// Authenticated Route Shields
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Member 3: Dashboard & Filtering Scopes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'search'])->name('groups.search');

    // Member 1: User Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Member 2: Group CRUD Actions
    Route::resource('groups', GroupController::class);

    // Member 4: Join Requests & Approvals
    Route::post('/groups/{group}/request', [RequestController::class, 'store'])->name('requests.store');
    Route::post('/requests/{request}/approve', [RequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{request}/decline', [RequestController::class, 'decline'])->name('requests.decline');

    // Member 5: Document Upload & Downloads
    Route::post('/groups/{group}/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');
});

require __DIR__.'/auth.php';


### 2. Models & Eloquent Relationships

**User Model (app/Models/User.php)**

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable {
    protected $fillable = ['name', 'email', 'password', 'matric_number', 'expertise_area'];

    // Groups created by this user
    public function ledGroups(): HasMany {
        return $this->hasMany(StudyGroup::class, 'leader_id');
    }

    // Groups joined by this user (Many-to-Many Relation)
    public function joinedGroups(): BelongsToMany {
        return $this->belongsToMany(StudyGroup::class, 'group_members', 'user_id', 'group_id');
    }

    // Requests sent by this user
    public function joinRequests(): HasMany {
        return $this->hasMany(JoinRequest::class);
    }
}


**StudyGroup Model (app/Models/StudyGroup.php)**

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudyGroup extends Model {
    protected $fillable = ['title', 'subject_code', 'description', 'venue', 'session_date', 'session_time', 'leader_id'];

    // Group Owner/Leader
    public function leader(): BelongsTo {
        return $this->belongsTo(User::class, 'leader_id');
    }

    // Approved Members (Many-to-Many Relation)
    public function members(): BelongsToMany {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }

    // Join requests received
    public function requests(): HasMany {
        return $this->hasMany(JoinRequest::class, 'group_id');
    }

    // Shared resources uploaded
    public function resources(): HasMany {
        return $this->hasMany(StudyResource::class);
    }

    // Query scope for searching study groups
    public function scopeSearchBySubject($query, $subjectCode) {
        if ($subjectCode) {
            return $query->where('subject_code', 'LIKE', '%' . $subjectCode . '%');
        }
    }
}


**JoinRequest Model (app/Models/JoinRequest.php)**

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JoinRequest extends Model {
    protected $fillable = ['user_id', 'group_id', 'motivation_note', 'status'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo {
        return $this->belongsTo(StudyGroup::class);
    }
}


**StudyResource Model (app/Models/StudyResource.php)**

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyResource extends Model {
    protected $fillable = ['study_group_id', 'file_name', 'file_path', 'file_type'];

    public function studyGroup(): BelongsTo {
        return $this->belongsTo(StudyGroup::class);
    }
}

### 3. Core Controllers Implemented

- **ProfileController:** Validates registration files, handles updating custom credentials, and manages user account configurations.
- **GroupController:** Handles standard Resource routing actions (create, store, edit, update, destroy) for organizing study groups.
- **DashboardController:** Compiles metrics, gathers query parameters, and displays study schedules.
- **RequestController:** Manages creation states for requests and runs transactional workflows when adding users to the group_members pivot table.
- **ResourceController:** Processes uploads, verifies extensions (PDF, JPEG, PNG), maps hash keys, and handles secure asset downloading.

### 4. Views and User Interface (Blade Design)

Compiled with Vite and styled using Tailwind CSS, our view layers utilize clean layouts:

- **layouts/app.blade.php:** Master dashboard skeleton containing sidebar links, alerts, and user dropdowns.
- **dashboard.blade.php:** The main workspace displaying schedules, filter search fields, and group listings.
- **groups/create.blade.php:** Group creation layouts featuring validation messages and date/time inputs.
- **groups/show.blade.php:** The workspace displaying shared resources, lists of members, request buttons, and approval modules.
- **profile/edit.blade.php:** Account customization components for editing matric numbers and areas of study.

## User Authentication System

### Authentication Features

1. **Custom Registration Requirements:** Enforces unique Matric Numbers and defined Expertise Areas upon account setup, keeping registration exclusive to verified students.
2. **Middleware Guards:** Utilizes the custom auth middleware stacks to ensure only group members can access files or post discussions.
3. **Leader Role Authorization:** Prevents unauthorized users from accessing group settings or approval actions.

### Security Measures

1. **Bcrypt Hashing:** Automatic password encryption during registration and profile updates.
2. **Cross-Site Request Forgery (CSRF) Defenses:** Automatic verification checks on all post forms.
3. **Protected File Access:** Files are stored in non-public storage directories and served through authenticated controller routes rather than public links.

## Installation and Setup Instructions

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- XAMPP (for running Apache & MySQL)

## Step-by-Step Installation

**1. Clone the Repository**

> git clone https://github.com/aimndnsh727/web-project-cosmik.git
cd web-project-cosmik


**2. Install Application Dependencies**

> composer install   
npm install


**3. Configure the Local Environment**

- Copy the environment template:

> cp .env.example .env


- Open the .env file and set your database connection:

>DB_CONNECTION=mysql    
DB_HOST=127.0.0.1     
DB_PORT=3306      
DB_DATABASE=cosmik_study_db      
DB_USERNAME=root       
DB_PASSWORD=


**4. Initialize DB Schema & Encryption**

- Generate your secure application encryption key:

> php artisan key:generate


- Create the database named cosmik_study_db using phpMyAdmin, and then run the migrations:

> php artisan migrate


- Link your storage folder to make uploaded files accessible:

> php artisan storage:link


**5. Run the Development Servers**

- Start the Laravel local server in your first terminal:

> php artisan serve


- Start the Vite asset builder in a separate terminal tab:

> npm run dev


- Open your web browser and go to: http://127.0.0.1:8000

## Testing and Quality Assurance

### Functionality Testing

- **Authentication Validation:** Confirmed that duplicate matric numbers are blocked during registration.
- **CRUD Rules:** Verified that dates set in the past or missing course codes return appropriate form validation errors.
- **Relationships & Pivot Tables:** Verified that join requests successfully transition to approved memberships, updating the pivot table.
- **File Uploads:** Confirmed that file uploads exceeding 5MB or using unapproved extensions (such as .exe or .sh) are automatically rejected.

### Browser Compatibility

- **Google Chrome & Microsoft Edge:** Rendered properly; responsive components and flex layouts adjust correctly across screen sizes.
- **Mozilla Firefox & Safari:** Checked form actions, modal dialogs, and navigation menus to ensure consistent styling.

## Challenges Faced and Solutions

**1. Handling Pivot States for Pending Requests**

- **Problem:** Adding a user directly to a Many-to-Many relationship immediately grants them full access. We needed an intermediate state for pending approvals before membership is confirmed.
- **Solution:** We designed an intermediate model called JoinRequest. When a request is approved, the system updates the request state and uses Eloquent's attach() method to create a new row in the group_members pivot table, granting the user full group access.

**2. Protecting Uploaded Study Assets**

- **Problem:** Storing academic files in public directories exposes them to hotlinking and search engine indexing, presenting a security vulnerability.
- **Solution:** We stored uploaded files in the protected storage/app/private directory. We then set up a controller action (download) that performs authentication checks before streaming the file content to the user's browser.

**3. Creating Chainable Search Scopes**

- **Problem:** Writing complex SQL query chains inside the dashboard controller led to messy, unmaintainable code.
- **Solution:** We implemented clean Eloquent Query Scopes (e.g., scopeSearchBySubject) directly within the StudyGroup model. This keeps the controller clean and makes search queries modular and easy to manage.

## Future Enhancements

- **Real-time Notifications:** Automated system notifications when join requests are approved or when new study materials are uploaded.
- **In-App Messaging:** Integrated discussion channels within study groups to help members coordinate meeting times directly on the platform.
- **Calendar Integration:** A feature allowing users to sync study group sessions directly with Google Calendar or Apple Calendar.

## Learning Outcomes

### Technical Skills Gained

- **Relational Database Design:** Hands-on experience designing Many-to-Many relationships, pivot tables, and custom models in Laravel.
- **Middleware Security:** Experience protecting application routes and sensitive files using custom middleware.
- **Modern Frontend Compiling:** Experience combining Blade layouts, Tailwind utility classes, and Vite asset bundling.

## Soft Skills Developed

- **Agile Collaboration:** Coordinating task distribution and combining individual components into a cohesive team project.
- **Git Workflows:** Experience managing code commits, branching, resolving merge conflicts, and tracking development progress on GitHub.
- **Ethical Web Design:** Building a secure, Shariah-compliant learning environment with focus on user privacy and academic integrity.

## References

1. Laravel Framework v11.x Documentation: https://laravel.com/docs/11.x
2. Tailwind CSS Reference: https://tailwindcss.com/docs
3. MDN Web Docs - MVC Architecture Guide: https://developer.mozilla.org/en-US/docs/Glossary/MVC
4. Git and Version Control Best Practices: https://git-scm.com/doc

## Conclusion

Cosmik addresses a common student challenge by providing a centralized, secure platform for organizing and joining academic study groups. By implementing custom authentication, robust search filters, and an interactive file storage vault, our team has built a responsive web application that demonstrates the practical benefits of the Model-View-Controller (MVC) architecture.

The development process has provided us with valuable, industry-standard experience in team collaboration, database management, and full-stack web application development.

## Video Presentation Link

Watch our Cosmik walkthrough and presentation on YouTube:
https://drive.google.com/drive/folders/16mMR_QWIrTNPf2ZxC8wZ_77hwWpbYuAZ?usp=sharing