<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Shared schedule string used across most consultant doctors.
     */
    private function defaultSchedule(): string
    {
        return "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed";
    }

    /**
     * Sample education & bio data keyed by title/specialty.
     */
    private function specialtyInfo(string $title): array
    {
        $map = [
            'Pathologist' => [
                'education' => "MBBS, MD (Pathology)\nFellowship in Histopathology\nDM (Molecular Pathology)",
                'bio' => "Dr. Uttara Chatterjee is a highly experienced pathologist with over 15 years of expertise in diagnostic pathology, histopathology, and cytology. She has been instrumental in establishing advanced diagnostic protocols at Park Clinic and is known for her meticulous approach to patient diagnosis."
            ],
            'Radiologist' => [
                'education' => "MBBS, MD (Radiology)\nFellowship in Interventional Radiology\nDNB (Radio-diagnosis)",
                'bio' => "Specializing in diagnostic and interventional radiology, our radiology team brings decades of combined experience in MRI, CT, ultrasound, and X-ray imaging. They work closely with referring physicians to ensure accurate and timely diagnoses using state-of-the-art imaging technology."
            ],
            'Cardiologist' => [
                'education' => "MBBS, MD (General Medicine)\nDM (Cardiology)\nFellowship in Interventional Cardiology",
                'bio' => "Our cardiology specialists are dedicated to providing comprehensive cardiac care, from preventive cardiology to advanced interventional procedures. They combine clinical expertise with cutting-edge technology to deliver the best outcomes for patients with heart conditions."
            ],
            'Medicine' => [
                'education' => "MBBS, MD (General Medicine)\nFRCP (Edinburgh)\nFellowship in Internal Medicine",
                'bio' => "Dr. Sujata Majumder is a renowned physician with extensive experience in internal medicine. She specializes in the diagnosis and management of complex medical conditions, offering personalized care plans tailored to each patient's unique needs."
            ],
            'Neurosurgeon' => [
                'education' => "MBBS, MS (General Surgery)\nMCh (Neurosurgery)\nDNB (Neurosurgery)",
                'bio' => "Our neurosurgery team is at the forefront of brain and spine surgery, offering advanced minimally invasive techniques for complex neurological conditions. With state-of-the-art operating facilities and a patient-centric approach, they ensure the highest standards of neurosurgical care."
            ],
            'Orthopaedic Surgeon' => [
                'education' => "MBBS, MS (Orthopaedics)\nDNB (Orthopaedics)\nFellowship in Joint Replacement",
                'bio' => "Specializing in orthopaedic surgery and joint replacement, our orthopaedic team provides comprehensive care for musculoskeletal conditions. From sports injuries to complex trauma and joint replacements, they are committed to restoring mobility and improving quality of life."
            ],
            'Paediatric Medicine' => [
                'education' => "MBBS, MD (Paediatrics)\nDNB (Paediatrics)\nFellowship in Neonatology",
                'bio' => "Our paediatric specialists are dedicated to the health and well-being of children from infancy through adolescence. With expertise in neonatology, developmental paediatrics, and adolescent medicine, they provide compassionate, family-centered care in a child-friendly environment."
            ],
            'Paediatric Surgery' => [
                'education' => "MBBS, MS (General Surgery)\nMCh (Paediatric Surgery)\nFICS, FAMS",
                'bio' => "Dr. Jahurul Haque is a distinguished paediatric surgeon with advanced training in neonatal and paediatric surgical procedures. He has successfully performed thousands of surgeries ranging from routine paediatric operations to complex congenital anomaly corrections."
            ],
            'Haematologist' => [
                'education' => "MBBS, MD (Pathology)\nDM (Clinical Haematology)\nFRCPath",
                'bio' => "Our haematology team specializes in the diagnosis and treatment of blood disorders including anaemia, coagulation disorders, and haematological malignancies. They work closely with the oncology department to provide integrated care for patients."
            ],
            'Haemato Oncco' => [
                'education' => "MBBS, MD (Internal Medicine)\nDM (Clinical Haematology)\nFellowship in Haemato-Oncology",
                'bio' => "Dr. Sramila Chandra is a leading haemato-oncologist with expertise in the management of blood cancers and bone marrow disorders. She is committed to providing compassionate, evidence-based care using the latest therapeutic protocols."
            ],
            'Endocrinologist' => [
                'education' => "MBBS, MD (General Medicine)\nDM (Endocrinology)\nFRCP, FACP",
                'bio' => "Specializing in hormonal and metabolic disorders, our endocrinology team manages conditions such as diabetes, thyroid disorders, osteoporosis, and pituitary diseases. They take a holistic approach to patient care, emphasizing lifestyle modification alongside medical treatment."
            ],
            'Neuropsurgeon' => [
                'education' => "MBBS, MS (General Surgery)\nMCh (Neurosurgery)\nFellowship in Spine Surgery",
                'bio' => "Dr. Gopal Acharya is a skilled neurosurgeon specializing in both cranial and spinal surgeries. He is experienced in minimally invasive spine techniques and complex brain tumor resections, prioritizing patient safety and recovery."
            ],
        ];

        // Default for unmatched titles
        return $map[$title] ?? [
            'education' => "MBBS\nMD (Respective Specialization)\nDNB\nFellowship in relevant sub-specialty",
            'bio' => "An experienced medical professional dedicated to providing exceptional patient care at Park Clinic. With years of specialized training and a commitment to continuous learning, they bring the latest medical advancements to every consultation."
        ];
    }

    /**
     * Schedule for outdoor department doctors.
     */
    private function outdoorSchedule(): string
    {
        return "Monday - Saturday: 10:00 AM - 4:00 PM\nSunday: Emergency only";
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate to prevent duplicate records on re-seed
        Doctor::truncate();

        // ── Consultant doctors (from doctors-page.data.ts) ──
        $consultants = [
            [
                'name' => 'Dr. Uttara Chatterjee',
                'title' => 'Pathologist',
                'experience' => '15 years',
                'rating' => 4.8,
                'image' => '/images/doc2.jpg',
                'education' => "MBBS, MD (Pathology)\nFellowship in Histopathology\nDM (Molecular Pathology)",
                'bio' => "Dr. Uttara Chatterjee is a highly experienced pathologist with over 15 years of expertise in diagnostic pathology, histopathology, and cytology. She has been instrumental in establishing advanced diagnostic protocols at Park Clinic and is known for her meticulous approach to patient diagnosis.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Pauline Ara Parveen',
                'title' => 'Pathologist',
                'experience' => '12 years',
                'rating' => 4.6,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Pathology)\nDNB (Pathology)\nFellowship in Cytopathology",
                'bio' => "Dr. Pauline Ara Parveen is a dedicated pathologist with 12 years of experience in clinical pathology and laboratory medicine. She specializes in cytopathology and hematopathology, providing accurate diagnostic support for complex clinical cases.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Sandip Kr. Batabyal',
                'title' => 'Pathologist',
                'experience' => '11 years',
                'rating' => 4.5,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Pathology)\nFellowship in Histopathology\nPG Diploma in Forensic Pathology",
                'bio' => "Dr. Sandip Kr. Batabyal brings 11 years of expertise in anatomical and clinical pathology. His areas of specialization include histopathology, immunohistochemistry, and forensic pathology, contributing significantly to the diagnostic capabilities at Park Clinic.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Rituparna Haldar',
                'title' => 'Pathologist',
                'experience' => '9 years',
                'rating' => 4.4,
                'image' => '/images/doc2.jpg',
                'education' => "MBBS, MD (Pathology)\nFellowship in Clinical Pathology",
                'bio' => "Dr. Rituparna Haldar is a skilled pathologist with 9 years of experience. She is proficient in histopathology, clinical pathology, and laboratory management, committed to delivering precise diagnostic results for optimal patient care.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Molay Roy',
                'title' => 'Pathologist',
                'experience' => '12 years',
                'rating' => 4.7,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Pathology)\nDNB (Pathology)\nFellowship in Oncopathology",
                'bio' => "Dr. Molay Roy is a senior pathologist with 12 years of expertise in oncopathology and hematopathology. He plays a key role in cancer diagnosis and staging, working closely with the oncology team to guide treatment decisions.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Shweta Khanna',
                'title' => 'Radiologist',
                'experience' => '10 years',
                'rating' => 4.6,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Radiology)\nFellowship in Interventional Radiology\nDNB (Radio-diagnosis)",
                'bio' => "Dr. Shweta Khanna is a skilled radiologist with 10 years of experience in diagnostic and interventional radiology. She specializes in MRI, CT angiography, and ultrasound-guided interventions, providing precise imaging support for clinical decision-making.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Souvik Ghosh',
                'title' => 'Radiologist',
                'experience' => '10 years',
                'rating' => 4.6,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Radiology)\nDNB (Radio-diagnosis)\nFellowship in Neuroradiology",
                'bio' => "Dr. Souvik Ghosh specializes in neuroradiology and musculoskeletal imaging. With 10 years of experience, he is adept at performing and interpreting advanced imaging studies including functional MRI and CT perfusion studies.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Debleena Mondal',
                'title' => 'Radiologist',
                'experience' => '8 years',
                'rating' => 4.9,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Radiology)\nFellowship in Breast Imaging\nDNB (Radio-diagnosis)",
                'bio' => "Dr. Debleena Mondal is a highly-rated radiologist with 8 years of experience. She has a special interest in breast imaging, women's imaging, and obstetric ultrasound, providing compassionate and accurate diagnostic services.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Adeep V',
                'title' => 'Radiologist',
                'experience' => '8 years',
                'rating' => 4.9,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Radiology)\nFellowship in Vascular & Interventional Radiology",
                'bio' => "Dr. Adeep V is an accomplished radiologist with expertise in vascular and interventional radiology. He specializes in minimally invasive image-guided procedures, offering patients alternatives to traditional surgery.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Shyamajit Samaddar',
                'title' => 'Cardiologist',
                'experience' => '9 years',
                'rating' => 4.5,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (General Medicine)\nDM (Cardiology)\nFellowship in Interventional Cardiology",
                'bio' => "Dr. Shyamajit Samaddar is a skilled cardiologist specializing in interventional cardiology. He performs coronary angiograms, angioplasties, and pacemaker implantations with a focus on patient safety and optimal cardiac outcomes.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. Lopamudra Mishra',
                'title' => 'Cardiologist',
                'experience' => '9 years',
                'rating' => 4.5,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (General Medicine)\nDM (Cardiology)\nFellowship in Echocardiography",
                'bio' => "Dr. Lopamudra Mishra is a dedicated cardiologist with expertise in non-invasive cardiology, echocardiography, and preventive cardiology. She is passionate about cardiac risk assessment and helping patients adopt heart-healthy lifestyles.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'Dr. P. Bhowmik',
                'title' => 'Cardiologist',
                'experience' => '9 years',
                'rating' => 4.5,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (General Medicine)\nDM (Cardiology)\nFellowship in Cardiac Electrophysiology",
                'bio' => "Dr. P. Bhowmik is a cardiologist specializing in cardiac electrophysiology and heart rhythm disorders. He manages complex arrhythmias and performs procedures including EPS studies and radiofrequency ablations.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
        ];

        // ── Home page featured doctors (from doctors-section.data.ts) ──
        $featured = [
            [
                'name' => 'DR. SUJATA MAJUMDER',
                'title' => 'Medicine',
                'rating' => 4.8,
                'reviews' => 150,
                'image' => '/images/doc2.jpg',
                'education' => "MBBS, MD (General Medicine)\nFRCP (Edinburgh)\nFellowship in Internal Medicine",
                'bio' => "Dr. Sujata Majumder is a renowned physician with extensive experience in internal medicine. She specializes in the diagnosis and management of complex medical conditions, offering personalized care plans tailored to each patient's unique needs.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'DR. RAHUL SAHA',
                'title' => 'Neurosurgeon',
                'rating' => 4.7,
                'reviews' => 140,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MS (General Surgery)\nMCh (Neurosurgery)\nDNB (Neurosurgery)",
                'bio' => "Dr. Rahul Saha is a highly skilled neurosurgeon specializing in complex brain and spine surgeries. He has extensive experience in micro neurosurgery, minimally invasive spine procedures, and neuro trauma management, providing compassionate care to patients with neurological disorders.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'DR. NILAY KANTI DAS',
                'title' => 'Orthopaedic Surgeon',
                'rating' => 4.6,
                'reviews' => 130,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MS (Orthopaedics)\nDNB (Orthopaedics)\nFellowship in Joint Replacement",
                'bio' => "Dr. Nilay Kanti Das is a seasoned orthopaedic surgeon specializing in joint replacement and arthroscopic surgery. He has performed over a thousand successful hip and knee replacements, helping patients regain mobility and live pain-free lives.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],

            [
                'name' => 'DR. KAUSHIK SHIL',
                'title' => 'Paediatric Medicine',
                'rating' => 4.5,
                'reviews' => 120,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, DCH\nMD (Paediatrics)\nFellowship in Paediatric Gastroenterology",
                'bio' => "Dr. Kaushik Shil is an experienced paediatrician with a special interest in paediatric gastroenterology and nutrition. He provides comprehensive care for children with digestive disorders and developmental concerns.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Emergency Only",
            ],
            [
                'name' => 'DR. SUDIP KUMAR GHOSH',
                'title' => 'Neurosurgeon',
                'rating' => 4.7,
                'reviews' => 145,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MS (General Surgery)\nMCh (Neurosurgery)\nFellowship in Spine Surgery",
                'bio' => "Dr. Sudip Kumar Ghosh is a specialist neurosurgeon with expertise in spinal disorders and cranial neurosurgery. He is skilled in minimally invasive spine techniques and complex brain tumour resections, ensuring the best possible outcomes for his patients.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'DR. GOPAL ACHARYA',
                'title' => 'Neurosurgeon',
                'rating' => 4.6,
                'reviews' => 135,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MS (General Surgery)\nMCh (Neurosurgery)\nFellowship in Cerebrovascular Surgery",
                'bio' => "Dr. Gopal Acharya is a skilled neurosurgeon specializing in cerebrovascular and skull base surgeries. With years of experience in managing complex neurological conditions, he is dedicated to providing comprehensive neurosurgical care with a patient-first approach.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'DR. SUDIP SAHA',
                'title' => 'Paediatric Medicine',
                'rating' => 4.8,
                'reviews' => 155,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Paediatrics)\nDNB (Paediatrics)\nFellowship in Paediatric Pulmonology",
                'bio' => "Dr. Sudip Saha is a dedicated paediatrician with expertise in paediatric pulmonology and respiratory medicine. He provides specialized care for children with asthma, allergies, and chronic respiratory conditions.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Emergency Only",
            ],
            [
                'name' => 'DR. MAITREYEE BHATTACHARYA',
                'title' => 'Haematologist',
                'rating' => 4.7,
                'reviews' => 140,
                'image' => '/images/doc2.jpg',
                'education' => "MBBS, MD (Pathology)\nDM (Clinical Haematology)\nFellowship in Haemato-Oncology",
                'bio' => "Dr. Maitreyee Bhattacharya is a clinical haematologist with expertise in blood disorders and haemato-oncology. She provides comprehensive care for patients with anaemia, coagulation disorders, leukaemia, and lymphoma, using the latest diagnostic and therapeutic approaches.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],
            [
                'name' => 'DR. SUGATO BANERJEE',
                'title' => 'Paediatric Medicine',
                'rating' => 4.4,
                'reviews' => 110,
                'image' => '/images/doc1.jpg',
                'education' => "MBBS, MD (Paediatrics)\nFellowship in Paediatric Cardiology",
                'bio' => "Dr. Sugato Banerjee is a paediatrician with specialized training in paediatric cardiology. He provides comprehensive cardiac care for children, from fetal echocardiography to adolescent heart health management.",
                'schedule' => "Monday - Friday: 10:00 AM - 6:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Emergency Only",
            ],
            [
                'name' => 'DR. SRAMILA CHANDRA',
                'title' => 'Haemato Oncco',
                'rating' => 4.9,
                'reviews' => 170,
                'image' => '/images/doc2.jpg',
                'education' => "MBBS, MD (Internal Medicine)\nDM (Clinical Haematology)\nFellowship in Bone Marrow Transplantation",
                'bio' => "Dr. Sramila Chandra is a leading haemato-oncologist and one of the few specialists in Eastern India offering bone marrow transplantation services. She is deeply committed to providing compassionate, evidence-based care for patients with blood cancers and haematological disorders.",
                'schedule' => "Monday - Friday: 9:00 AM - 5:00 PM\nSaturday: 9:00 AM - 1:00 PM\nSunday: Closed",
            ],

        ];

        // ── Outdoor doctors (from outdoor-services.tsx) ──
        $outdoor = [
            ['department' => 'SPECIALIST PHYSICIAN - GENERAL MEDICINE',  'doctors' => ['Dr. Sujata Mazumdar, MD', 'Dr. Aritra Kr Ray, MBBS, MD', 'Dr. Sujoy Panchadhyayee, MBBS, MD', 'Dr. Omar Sharif Mullick, MBBS, MD', 'Dr. Pushpita Mandal, MBBS, MD']],
            ['department' => 'PAEDIATRIC SURGERY',                     'doctors' => ['Dr. Ashoke Kr. Basu, MS, Mch, DNB, MNAMS, FAIS, FICA', 'Dr. Sugato Banerjee, MS, Mch', 'Dr. Udaysankar chatterjee, MS, Mch, Mch(Uro)', 'Dr. Debasish Mitra, MS, Mch, MRCS', 'Dr. Dhananjay Basak, MS, Mch, MNAMS', 'Dr. Kuntal Bhaumik, MS, Mch, FIAS, FICS', 'Dr. Sanghamitra Bhattacharyya, MBBS., MS., Mch.']],
            ['department' => 'GENERAL SURGERY',                        'doctors' => ['Dr. Suvro Ganguly, MBBS., MS., MRCS.']],
            ['department' => 'ORTHOPAEDIC SURGEON',                    'doctors' => ['Dr. Ariful islam, MS (Ortho), DNB(Ortho), MNAMS', 'Dr. Abhilash Sarkar, MS (Ortho)', 'Dr. Kaunteya Ghosh, MBBS., MS']],
            ['department' => 'BRAIN & SPINE SURGERY',                  'doctors' => ['Dr. Gopal Achari, MBBS, MS, MCH.', 'Dr. Kaushik Sil, MBBS, MS, DNB.', 'Dr. Niloy Biswas, MBBS, MS, MRCS, MCH.', 'Dr. S.N. Ghosh D(Orth) M.S, DNB., MCH.', 'Dr. Pankaj Shivare , MS, MCH.', 'Dr. Rahul Saha, MBBS, DNB (Neusurg.) MNAMS', 'Dr. Rituparna Haldar - M.D.', 'Dr. Sudip Ghosh, MBBS, MS., DrNB. (Neusurg.)']],
            ['department' => 'NEUROLOGIST',                            'doctors' => ['Dr. Ambar Chakravarty, FIAN, MD, FRCP, FICP', 'Dr. Tapas Kumar Banerjee, MD., FRCP, FAAN', 'Dr. Amit Halder, MD., DM.', 'Dr. Goutam Ganguly, MD., DM. (Neuro)', 'Dr. Kalyan Brata Bhattacharyya, FIAN, FRCP (Edin)', 'Dr. Ankur Banik, MBBS., MD., DM.']],
            ['department' => 'UROLOGIST',                              'doctors' => ['Dr. Himadri Pathak, DNB, MNAMS', 'Dr. Dipankar Bera, MBBS., MS., M.Ch.', 'Dr. Zeeshan Rahman, MBBS., MS., M.Ch.']],
            ['department' => 'GYNAECOLOGIST & OBSTETRICIAN',           'doctors' => ['Dr. Shabana Munshi, MBBS., DGO., DNB.', 'Dr. Meenakshi Karan, MBBS., MD., FNB.']],
            ['department' => 'HEMATOLOGIST',                           'doctors' => ['Dr. Sarmila Chandra, MD', 'Dr. Maitreyi Bhattacharyya, MD., DM']],
            ['department' => 'SURGICAL ONCOLOGIST',                    'doctors' => ['Dr. Arunabha Sengupta, MS']],
            ['department' => 'CARDIOLOGIST',                           'doctors' => ['Dr. Debapriyo Mondal, MBBS., MD., DM.']],
            ['department' => 'NEPHROLOGIST',                           'doctors' => ['Dr. Tapabrata Das, MBBS., MD., DM.']],
            ['department' => 'PAEDIATRIC NEUROLOGIST',                 'doctors' => ['Dr. Jasodhara Chaudhuri, MD. (Ped), MRCPCH, DM. (Neuro)']],
            ['department' => 'GASTROENTEROLOGY & HEPATOLOGIST',         'doctors' => ['Dr. Chandan Kumar Das, MBBS., MD., DM.', 'Dr. Sugato Narayan Biswas, MBBS., MD., DM.']],
            ['department' => 'GASTROENTEROLOGICAL & LAPAROSCOPIC SURGERY', 'doctors' => ['Dr. Kalyanashis Mukherjee, DNB']],
            ['department' => 'RHEUMATOLOGIST',                         'doctors' => ['Dr. Debasish Kumar, MRCP']],
            ['department' => 'ENDOCRINE & BREAST SURGERY',             'doctors' => ['Dr. Dhritiman Moitro, MS, Mch.']],
            ['department' => 'BREAST & PLASTIC SURGERY',               'doctors' => ['Dr. Suparna Ghosh, MBBS, MS, Mch', 'Prof. Dr. Srinjoy Saha, MBBS, MS, MCH(plast), FACS, FRCS (G Larg.)']],
            ['department' => 'E.N.T. SURGEON',                         'doctors' => ['Dr. Sudipta Chandra, MBBS, MS (ENT), FRCS']],
            ['department' => 'PSYCHIATRIST',                           'doctors' => ['Dr. Amlan Kusum Jana, MBBS, MD, DPM, MRCP SYCN', 'Dr. Rudraprasad Acharya, MBBS, MD']],
            ['department' => 'PAEDIATRIC GASTROENTEROLOGIST',          'doctors' => ['Dr. Gautam Ray, MD. (Ped), MRCPCH, DM. (Paed. Gastro)']],
            ['department' => 'DERMATOLOGIST',                          'doctors' => ['Dr. Sambit Chaatterjee, MBBS., MD-DVL (WBUHS)', 'Dr. Arindrajit Panja, MBBS., MD.']],
            ['department' => 'PSYCHOLOGIST',                           'doctors' => ['Dr. Ranjan Roy Chowdhury, MS(ENT), FRCS', 'Dr. Debarshi Roy, MBBS, MS (ENT), MRCS, DOHNS']],
        ];

        $outdoorSchedule = "Monday - Saturday: 10:00 AM - 4:00 PM\nSunday: Emergency only";

        // ── Dual-type doctors (both consultant AND outdoor) ──
        // These doctors provide both indoor consultation and outdoor OPD services
        $dualType = [
            [
                'name'       => 'Dr. Surajit Santra',
                'title'      => 'Paediatric Medicine',
                'department' => 'PAEDIATRICIAN',
                'experience' => '15 years',
                'rating'     => 4.9,
                'reviews'    => 160,
                'image'      => '/images/doc1.jpg',
                'education'  => "MBBS, DCH, DNB (Paediatrics)\nMNAMS\nFellowship in Neonatology",
                'bio'        => "Dr. Surajit Santra is a distinguished paediatrician with expertise in neonatology and paediatric critical care. He offers both indoor consultation at the clinic and outdoor OPD services, ensuring comprehensive care for children.",
                'schedule'   => "Consultant: Monday - Friday 9:00 AM - 1:00 PM\nOutdoor: Monday - Saturday 2:00 PM - 4:00 PM\nSunday: Emergency Only",
            ],
            [
                'name'       => 'Dr. Sudip Chatterjee',
                'title'      => 'Endocrinologist',
                'department' => 'ENDOCRINOLOGIST',
                'experience' => '20+ years',
                'rating'     => 4.6,
                'reviews'    => 135,
                'image'      => '/images/doc1.jpg',
                'education'  => "MBBS, MD (General Medicine)\nDM (Endocrinology)\nFRCP, FACP",
                'bio'        => "Dr. Sudip Chatterjee is a renowned endocrinologist with national and international recognition. He attends both consultant outpatient clinics and manages the outdoor endocrinology department for walk-in patients.",
                'schedule'   => "Consultant: Monday - Friday 9:00 AM - 12:00 PM\nOutdoor: Monday - Saturday 12:00 PM - 3:00 PM\nSunday: Closed",
            ],
            [
                'name'       => 'Dr. Jahurul Haque',
                'title'      => 'Paediatric Surgery',
                'department' => 'PAEDIATRIC SURGERY',
                'experience' => '25+ years',
                'rating'     => 4.7,
                'reviews'    => 145,
                'image'      => '/images/doc1.jpg',
                'education'  => "MBBS, MS (General Surgery)\nMCh (Paediatric Surgery)\nFAMS, FICS",
                'bio'        => "Dr. Jahurul Haque is a distinguished paediatric surgeon who sees patients for both indoor consultation and outdoor OPD. He specializes in congenital anomaly correction and minimally invasive paediatric surgery.",
                'schedule'   => "Consultant: Tuesday & Thursday 9:00 AM - 1:00 PM\nOutdoor: Monday, Wednesday, Friday 10:00 AM - 4:00 PM\nSaturday: Emergency Only",
            ],
            [
                'name'       => 'Dr. Nikhileswar Khawash',
                'title'      => 'Paediatric Medicine',
                'department' => 'PAEDIATRICIAN',
                'experience' => '18 years',
                'rating'     => 4.3,
                'reviews'    => 105,
                'image'      => '/images/doc1.jpg',
                'education'  => "MBBS, DCH, MD (Paediatrics)\nFRCP\nFellowship in Paediatric Neurology",
                'bio'        => "Dr. Nikhileswar Khawash is a senior paediatrician with a special interest in paediatric neurology. He provides consultant services for referred patients and also operates outdoor OPD clinics for general paediatric care.",
                'schedule'   => "Consultant: Monday - Friday 9:00 AM - 12:00 PM\nOutdoor: Monday - Saturday 3:00 PM - 5:00 PM\nSunday: Emergency Only",
            ],
        ];

        // Insert consultant doctors (from doctors-page.data.ts)
        foreach ($consultants as $doctor) {
            Doctor::create(array_merge($doctor, ['type' => ['consultant']]));
        }

        // Insert featured home page doctors
        foreach ($featured as $doctor) {
            Doctor::create(array_merge($doctor, ['type' => ['consultant']]));
        }

        // Insert outdoor doctors with schedule only
        foreach ($outdoor as $group) {
            $department = $group['department'];
            foreach ($group['doctors'] as $name) {
                Doctor::create([
                    'name'       => $name,
                    'department' => $department,
                    'type'       => ['outdoor'],
                    'schedule'   => $outdoorSchedule,
                ]);
            }
        }

        // Insert dual-type doctors (both consultant and outdoor)
        foreach ($dualType as $doctor) {
            Doctor::create(array_merge($doctor, ['type' => ['consultant', 'outdoor']]));
        }
    }
}
