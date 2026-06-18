<?php

namespace Database\Seeders;

use App\Models\JobPost;
use App\Models\CareerApplication;
use Illuminate\Database\Seeder;

class JobPostAndApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate to prevent duplicate records on re-seed
        JobPost::truncate();
        CareerApplication::truncate();

        $now = now();
        $today = $now->toDateString();

        // ── 20 Job Posts ────────────────────────────────────────────
        $jobs = [
            // Active jobs (is_active = true, deadline in future or null)
            [
                'title'          => 'Senior Staff Nurse – ICU',
                'description'    => 'We are seeking an experienced ICU nurse to join our critical care team. The ideal candidate will have at least 3 years of ICU experience, BLS/ACLS certification, and a strong commitment to patient-centered care. Responsibilities include monitoring vital signs, administering medications, coordinating with physicians, and providing emotional support to patients and families.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(30)->toDateString(),
                'created_at'     => $now->copy()->subDays(1),
            ],
            [
                'title'          => 'Lab Technician – Pathology',
                'description'    => 'Park Clinic is looking for a skilled lab technician to join our pathology department. The role involves specimen collection, processing, and analysis across hematology, biochemistry, and microbiology. Candidates must have a DMLT/BMLT degree and at least 2 years of laboratory experience.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(45)->toDateString(),
                'created_at'     => $now->copy()->subDays(2),
            ],
            [
                'title'          => 'Front Desk Receptionist',
                'description'    => 'We are hiring a friendly and organized front desk receptionist to manage patient check-ins, appointment scheduling, phone inquiries, and billing support. Proficiency in hospital management software and excellent communication skills are required.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(20)->toDateString(),
                'created_at'     => $now->copy()->subDays(3),
            ],
            [
                'title'          => 'Pharmacist',
                'description'    => 'Park Clinic requires a qualified pharmacist to manage our in-house pharmacy. Duties include dispensing medications, counseling patients, maintaining inventory, and ensuring compliance with regulatory standards. A B.Pharm degree and valid pharmacy license are mandatory.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(60)->toDateString(),
                'created_at'     => $now->copy()->subDays(5),
            ],
            [
                'title'          => 'Medical Records Officer',
                'description'    => 'We are looking for a detail-oriented medical records officer to maintain and organize patient records, ensure data accuracy, handle record requests, and support our digital transition to EHR systems. Prior experience in healthcare documentation is preferred.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(25)->toDateString(),
                'created_at'     => $now->copy()->subDays(7),
            ],
            [
                'title'          => 'Radiology Technician',
                'description'    => 'Join our radiology team! We need a certified radiology technician to perform X-rays, CT scans, and MRIs. The ideal candidate holds a degree in radiography and has experience operating modern imaging equipment. Knowledge of radiation safety protocols is essential.',
                'is_active'      => true,
                'apply_duration' => null,
                'created_at'     => $now->copy()->subDays(10),
            ],
            [
                'title'          => 'Accounts Executive',
                'description'    => 'Park Clinic is seeking an accounts executive to handle billing, insurance claims, vendor payments, and financial reporting. Candidates should have a B.Com degree and at least 3 years of experience in healthcare finance or a related field.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(15)->toDateString(),
                'created_at'     => $now->copy()->subDays(14),
            ],
            // Recently posted active jobs (for "New" badge testing)
            [
                'title'          => 'Junior Nurse – OPD',
                'description'    => 'We have an opening for a junior nurse in our outpatient department. Responsibilities include assisting doctors during consultations, preparing patients for examinations, administering injections, and maintaining a clean clinical environment. Fresh graduates with a GNM/B.Sc Nursing degree are welcome to apply.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(40)->toDateString(),
                'created_at'     => $now->copy()->subHours(6),
            ],
            [
                'title'          => 'IT Support Specialist',
                'description'    => 'Park Clinic needs an IT support specialist to maintain our computer systems, networks, and hospital management software. The role includes troubleshooting hardware/software issues, managing user accounts, and ensuring cybersecurity best practices.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(21)->toDateString(),
                'created_at'     => $now->copy()->subHours(12),
            ],
            [
                'title'          => 'Housekeeping Supervisor',
                'description'    => 'We are looking for a housekeeping supervisor to lead our cleaning staff and ensure the highest standards of hygiene and sanitation across the clinic. Experience in hospital housekeeping management is preferred.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->addDays(35)->toDateString(),
                'created_at'     => $now->copy()->subDays(4),
            ],
            // Inactive jobs (manually deactivated, not expired)
            [
                'title'          => 'Security Guard',
                'description'    => 'We are hiring security guards for day and night shifts. Responsibilities include monitoring entry/exit points, patrolling premises, managing visitor logs, and responding to emergencies. Previous experience in healthcare security is a plus.',
                'is_active'      => false,
                'apply_duration' => $now->copy()->addDays(90)->toDateString(),
                'created_at'     => $now->copy()->subDays(20),
            ],
            [
                'title'          => 'Dietitian / Nutritionist',
                'description'    => 'Park Clinic seeks a clinical dietitian to design patient meal plans, provide nutritional counseling, and collaborate with medical teams on dietary management for chronic conditions. A Master\'s degree in Nutrition and hospital experience required.',
                'is_active'      => false,
                'apply_duration' => $now->copy()->addDays(50)->toDateString(),
                'created_at'     => $now->copy()->subDays(25),
            ],
            [
                'title'          => 'Ambulance Driver',
                'description'    => 'We need an experienced ambulance driver with a valid heavy vehicle license and emergency response training. The candidate must be familiar with city routes and capable of handling emergency situations calmly and efficiently.',
                'is_active'      => false,
                'apply_duration' => null,
                'created_at'     => $now->copy()->subDays(30),
            ],
            // Expired jobs (deadline passed, some active some inactive)
            [
                'title'          => 'Consultant Cardiologist',
                'description'    => 'Park Clinic invites applications for a consultant cardiologist. The candidate should have DM in Cardiology and experience in interventional procedures. This is a part-time visiting consultant position with flexible scheduling.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->subDays(5)->toDateString(),
                'created_at'     => $now->copy()->subDays(35),
            ],
            [
                'title'          => 'Physiotherapist',
                'description'    => 'We are looking for a full-time physiotherapist to join our rehabilitation department. The ideal candidate holds a BPT/MPT degree and has experience in musculoskeletal and neurological rehabilitation.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->subDays(10)->toDateString(),
                'created_at'     => $now->copy()->subDays(40),
            ],
            [
                'title'          => 'Medical Social Worker',
                'description'    => 'Park Clinic requires a medical social worker to assist patients with counseling, discharge planning, and connecting them to community resources. An MSW degree and hospital experience are required.',
                'is_active'      => false,
                'apply_duration' => $now->copy()->subDays(3)->toDateString(),
                'created_at'     => $now->copy()->subDays(33),
            ],
            [
                'title'          => 'Biomedical Engineer',
                'description'    => 'We are hiring a biomedical engineer to maintain and repair medical equipment including ventilators, monitors, and diagnostic devices. A B.E./B.Tech in Biomedical Engineering and 2+ years of experience required.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->subDays(15)->toDateString(),
                'created_at'     => $now->copy()->subDays(50),
            ],
            [
                'title'          => 'Hospital Administrator',
                'description'    => 'Park Clinic seeks an experienced hospital administrator to oversee daily operations, manage staff schedules, ensure regulatory compliance, and improve patient experience. An MHA degree and 5+ years of experience are required.',
                'is_active'      => false,
                'apply_duration' => $now->copy()->subDays(7)->toDateString(),
                'created_at'     => $now->copy()->subDays(45),
            ],
            [
                'title'          => 'CSSD Technician',
                'description'    => 'We need a Central Sterile Supply Department technician to manage sterilization of surgical instruments and supplies. Certification in CSSD operations and knowledge of infection control protocols are essential.',
                'is_active'      => true,
                'apply_duration' => $now->copy()->subDays(1)->toDateString(),
                'created_at'     => $now->copy()->subDays(28),
            ],
            [
                'title'          => 'Marketing Executive',
                'description'    => 'Park Clinic is looking for a marketing executive to promote our services, manage social media, organize health camps, and build partnerships with local organizations. A degree in marketing and healthcare marketing experience preferred.',
                'is_active'      => false,
                'apply_duration' => $now->copy()->subDays(20)->toDateString(),
                'created_at'     => $now->copy()->subDays(55),
            ],
        ];

        foreach ($jobs as $job) {
            JobPost::create($job);
        }

        // ── Career Applications ─────────────────────────────────────
        // Apply to job titles that exist in our seeded posts
        $applications = [
            [
                'full_name'    => 'Ananya Sharma',
                'email'        => 'ananya.sharma@example.com',
                'phone'        => '+91 9876543210',
                'position'     => 'Senior Staff Nurse – ICU',
                'message'      => 'I have 5 years of ICU experience at AMRI Hospital. I am passionate about critical care and would love to join Park Clinic.',
                'resume_path'  => 'resumes/ananya-sharma.pdf',
                'created_at'   => $now->copy()->subDays(2),
            ],
            [
                'full_name'    => 'Rahul Verma',
                'email'        => 'rahul.verma@example.com',
                'phone'        => '+91 9876543211',
                'position'     => 'Lab Technician – Pathology',
                'message'      => 'BMLT graduate with 3 years of experience in a multi-specialty hospital lab.',
                'resume_path'  => 'resumes/rahul-verma.pdf',
                'created_at'   => $now->copy()->subDays(3),
            ],
            [
                'full_name'    => 'Priya Banerjee',
                'email'        => 'priya.banerjee@example.com',
                'phone'        => '+91 9876543212',
                'position'     => 'Front Desk Receptionist',
                'message'      => 'I have excellent communication skills and 2 years of experience as a medical receptionist.',
                'resume_path'  => 'resumes/priya-banerjee.pdf',
                'created_at'   => $now->copy()->subDays(1),
            ],
            [
                'full_name'    => 'Amit Kumar Das',
                'email'        => 'amit.das@example.com',
                'phone'        => '+91 9876543213',
                'position'     => 'Pharmacist',
                'message'      => 'B.Pharm graduate with 4 years of hospital pharmacy experience.',
                'resume_path'  => 'resumes/amit-das.pdf',
                'created_at'   => $now->copy()->subDays(5),
            ],
            [
                'full_name'    => 'Sneha Roy',
                'email'        => 'sneha.roy@example.com',
                'phone'        => '+91 9876543214',
                'position'     => 'Medical Records Officer',
                'message'      => 'Experienced in EHR systems and medical record management at a 200-bed hospital.',
                'resume_path'  => 'resumes/sneha-roy.pdf',
                'created_at'   => $now->copy()->subDays(7),
            ],
            [
                'full_name'    => 'Vikram Singh',
                'email'        => 'vikram.singh@example.com',
                'phone'        => '+91 9876543215',
                'position'     => 'Radiology Technician',
                'message'      => 'Certified radiography technologist with 6 years of experience in CT and MRI.',
                'resume_path'  => 'resumes/vikram-singh.pdf',
                'created_at'   => $now->copy()->subDays(10),
            ],
            [
                'full_name'    => 'Tanushree Ghosh',
                'email'        => 'tanushree.ghosh@example.com',
                'phone'        => '+91 9876543216',
                'position'     => 'Junior Nurse – OPD',
                'message'      => 'Fresh GNM graduate eager to begin my nursing career at a reputed clinic.',
                'resume_path'  => 'resumes/tanushree-ghosh.pdf',
                'created_at'   => $now->copy()->subHours(5),
            ],
            [
                'full_name'    => 'Debashis Mukherjee',
                'email'        => 'debashis.m@example.com',
                'phone'        => '+91 9876543217',
                'position'     => 'IT Support Specialist',
                'message'      => 'B.Tech in IT with 3 years of experience managing hospital information systems.',
                'resume_path'  => 'resumes/debashis-mukherjee.pdf',
                'created_at'   => $now->copy()->subHours(10),
            ],
            [
                'full_name'    => 'Fatima Begum',
                'email'        => 'fatima.begum@example.com',
                'phone'        => '+91 9876543218',
                'position'     => 'Consultant Cardiologist',
                'message'      => 'DM Cardiology with 8 years of experience. Interested in a visiting consultant role.',
                'resume_path'  => 'resumes/fatima-begum.pdf',
                'created_at'   => $now->copy()->subDays(30),
            ],
            [
                'full_name'    => 'Arjun Nair',
                'email'        => 'arjun.nair@example.com',
                'phone'        => '+91 9876543219',
                'position'     => 'Physiotherapist',
                'message'      => 'MPT in Orthopaedics with 5 years of experience in post-surgical rehabilitation.',
                'resume_path'  => 'resumes/arjun-nair.pdf',
                'created_at'   => $now->copy()->subDays(35),
            ],
            [
                'full_name'    => 'Meera Joshi',
                'email'        => 'meera.joshi@example.com',
                'phone'        => '+91 9876543220',
                'position'     => 'Senior Staff Nurse – ICU',
                'message'      => '7 years of ICU nursing experience including charge nurse responsibilities.',
                'resume_path'  => 'resumes/meera-joshi.pdf',
                'created_at'   => $now->copy()->subDays(1),
            ],
            [
                'full_name'    => 'Karan Patel',
                'email'        => 'karan.patel@example.com',
                'phone'        => '+91 9876543221',
                'position'     => 'Housekeeping Supervisor',
                'message'      => '10 years of experience in hospital housekeeping and infection control.',
                'resume_path'  => 'resumes/karan-patel.pdf',
                'created_at'   => $now->copy()->subDays(3),
            ],
            [
                'full_name'    => 'Isha Agarwal',
                'email'        => 'isha.agarwal@example.com',
                'phone'        => '+91 9876543222',
                'position'     => 'Accounts Executive',
                'message'      => 'B.Com + MBA with 4 years of healthcare finance experience.',
                'resume_path'  => 'resumes/isha-agarwal.pdf',
                'created_at'   => $now->copy()->subDays(12),
            ],
            [
                'full_name'    => 'Sourav Chakraborty',
                'email'        => 'sourav.c@example.com',
                'phone'        => '+91 9876543223',
                'position'     => 'Biomedical Engineer',
                'message'      => 'B.E. Biomedical with 3 years of experience in medical equipment maintenance.',
                'resume_path'  => 'resumes/sourav-chakraborty.pdf',
                'created_at'   => $now->copy()->subDays(40),
            ],
            [
                'full_name'    => 'Pallavi Sen',
                'email'        => 'pallavi.sen@example.com',
                'phone'        => '+91 9876543224',
                'position'     => 'Dietitian / Nutritionist',
                'message'      => 'M.Sc. Nutrition with hospital clinical dietetics experience.',
                'resume_path'  => 'resumes/pallavi-sen.pdf',
                'created_at'   => $now->copy()->subDays(20),
            ],
        ];

        foreach ($applications as $app) {
            CareerApplication::create($app);
        }

        $this->command->info('Seeded ' . count($jobs) . ' job posts and ' . count($applications) . ' career applications.');
    }
}
