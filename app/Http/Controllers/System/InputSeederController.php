<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Input;
use App\Models\InputDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InputSeederController extends Controller
{
    public function input()
    {
        $this->categories();
        $this->ali_input();
        $this->cvi_input();
        $this->aorta_input();

        return $this->response;
    }

    private function categories()
    {
        $data = [
            // ALI
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'IDENTITY',
                'label'      => 'identity',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'DIAGNOSE',
                'label'      => 'diagnose',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'COMORBID',
                'label'      => 'comorbid',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'PHYSICAL EXAMINATION',
                'label'      => 'physical_examination',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'RISK FACTORS',
                'label'      => 'risk_factors',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'DIAGNOSTIC STUDIES',
                'label'      => 'diagnostic_studies',
                'children'   => [
                    [
                        'project_id' => 1,
                        'name'       => 'Echocardiography',
                        'label'      => 'echocardiography',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'Laboratory Findings',
                        'label'      => 'laboratory_findings',
                    ],
                ]
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'INTERVENTION',
                'label'      => 'intervention',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'TREATMENTS',
                'label'      => 'treatments',
                'children'   => [
                    [
                        'project_id' => 1,
                        'name'       => 'Fribinolytic',
                        'label'      => 'fibrinolytic',
                    ],
                ]
            ],
            [
                'project_id' => 1,
                'parent_id'  => 1,
                'name'       => 'OUTCOME',
                'label'      => 'outcome',
            ],

            // CVI
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'IDENTITY',
                'label'      => 'identity',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'RISK FACTORS',
                'label'      => 'cvi_risk_factors',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'DIAGNOSTIC STUDIES',
                'label'      => 'diagnostic_studies',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'LEG CONDITION',
                'label'      => 'leg_condition',
                'children'   => [
                    [
                        'project_id' => 1,
                        'name'       => 'Ulceration (if Active)',
                        'label'      => 'ulceration_if_active',
                    ],
                ]
            ],
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'SCORING AND CLASSIFICATION SYSTEMS',
                'label'      => 'scoring_and_classification_systems',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'TREATMENTS',
                'label'      => 'treatments',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 2,
                'name'       => 'QUALITY OF LIFE MEASUREMENT',
                'label'      => 'quality_of_life_measurement',
                'children'   => [
                    [
                        'project_id' => 1,
                        'name'       => 'The Chronic Venous Insufficiency Quality of Life Questionnaire (CIVIQ)',
                        'label'      => 'quality_of_life_measurement_1',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'During the past four weeks, how much trouble have you experienced carrying out the actions and activities listed below because of your leg problems?',
                        'label'      => 'quality_of_life_measurement_2',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'Leg problems can also affect your mood. How closely do the following statements correspond to what you have felt during the past four weeks?',
                        'label'      => 'quality_of_life_measurement_3',
                    ],
                ]
            ],

            // AORTA
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'IDENTITY',
                'label'      => 'identity',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'RISK FACTORS',
                'label'      => 'risk_factors',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'LENGTH OF STAY',
                'label'      => 'length_of_stay',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'MEDICAL HISTORY',
                'label'      => 'medical_history',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'PHYSICAL EXAMINATION',
                'label'      => 'physical_examination',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'DIAGNOSTIC STUDIES',
                'label'      => 'diagnostic_studies',
                'children'   => [
                    [
                        'project_id' => 1,
                        'name'       => 'Laboratory findings',
                        'label'      => 'laboratory_findings',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'EKG',
                        'label'      => 'ekg',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'Echocardiography',
                        'label'      => 'echocardiography',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'Echocardiography',
                        'label'      => 'echocardiography',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'Rontgen Thorax',
                        'label'      => 'rontgen_thorax',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'CT Angiography',
                        'label'      => 'ct_angiography',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'MSCT Coroner',
                        'label'      => 'msct_coroner',
                    ],
                ]
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'DIAGNOSE',
                'label'      => 'diagnose',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'THERAPY',
                'label'      => 'therapy',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'INTERVENTION',
                'label'      => 'intervention',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'COMPLICATION',
                'label'      => 'complication',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'DEATH',
                'label'      => 'death',
            ],
            [
                'project_id' => 1,
                'parent_id'  => 3,
                'name'       => 'FOLLOW UP',
                'label'      => 'follow_up',
                'children'   => [
                    [
                        'project_id' => 1,
                        'name'       => 'FOLLOW UP 1 MONTH',
                        'label'      => 'follow_up_1',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'FOLLOW UP 6 MONTH',
                        'label'      => 'follow_up_6',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'FOLLOW UP 12 MONTH',
                        'label'      => 'follow_up_12',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'FOLLOW UP 24 MONTH',
                        'label'      => 'follow_up_24',
                    ],
                    [
                        'project_id' => 1,
                        'name'       => 'FOLLOW UP 36 MONTH',
                        'label'      => 'follow_up_36',
                    ],
                ]
            ],
        ];

        foreach ($data as $item) {
            $cat = Category::whereParentId($item['parent_id'])
                ->whereLabel($item['label'])
                ->first();

            if (!$cat) {
                $cat = Category::create($item);
            }

            if (isset($item['children'])) {
                foreach ($item['children'] as $child) {
                    $cat_cld = Category::whereParentId($cat['id'])
                        ->whereLabel($child['label'])
                        ->first();

                    if (!$cat_cld) {
                        Category::create([
                            'project_id' => $child['project_id'],
                            'parent_id'  => $cat['id'],
                            'name'       => $child['name'],
                            'label'      => $child['label'],
                        ]);
                    }
                }
            }
        }
    }

    private function ali_input()
    {
        $parent_id = 1;
        $identity = [
            ['name' => 'Admission', 'type' => 'date'],
            ['name' => 'Medical Record Number', 'type' => 'text',],
            ['name' => 'Sex', 'type' => 'radio', 'children' => $this->input_details('gender')],
            ['name' => 'Phone Number', 'type' => 'text',],
            ['name' => 'Lenth of Stay', 'type' => 'number', 'suffix' => 'day'],
        ];

        $this->insert_input($identity, 'identity', $parent_id);

        $diagnose = [
            ['name' => 'Symptoms onset ', 'type' => 'textarea', 'note' => "How many days the onset of symptoms?"],
            ['name' => 'Rutherford', 'type' => 'checkbox', 'children' => $this->input_details('rutherford')],
        ];

        $this->insert_input($diagnose, 'diagnose', $parent_id);

        $comorbid = [
            ['name' => 'DVT', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'CLTI', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Infection', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Renal Failure', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'CHF', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Stroke', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'CAD', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'CVD', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Autoimmune', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Autoimmune Description', 'type' => 'textarea', "note" => "type of disease"],
            ['name' => 'Other', 'type' => 'textarea'],
        ];

        $this->insert_input($comorbid, 'comorbid', $parent_id);

        $physical_examination = [
            ['name' => 'Blood Pressure', 'type' => 'text'],
            ['name' => 'Necrosis/Gangrene', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Sensory Loss ', 'type' => 'radio', 'children' => $this->input_details('sensory_loss')],
            ['name' => 'Saturation of Feet Finger (Right Digiti I)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Right Digiti II)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Right Digiti III)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Right Digiti IV)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Right Digiti V)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Left Digiti I)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Left Digiti II)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Left Digiti III)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Left Digiti IV)', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Saturation of Feet Finger (Left Digiti V)', 'type' => 'number', 'suffix' => '%'],
        ];
        $this->insert_input($physical_examination, 'physical_examination', $parent_id);

        $risk_factors = [
            ['name' => 'Age', 'type' => 'number', 'suffix' => 'year'],
            ['name' => 'Weight', 'type' => 'number', 'suffix' => 'kg'],
            ['name' => 'Height', 'type' => 'number', 'suffix' => 'cm'],
            ['name' => 'Dyslipidemia', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'AF', 'type' => 'radio', 'children' => $this->input_details('bool')],
//            ['name' => 'Dyslipidemia Description', 'type' => 'textarea'],
//            ['name' => 'Medical History', 'type' => 'select', 'children' => $this->input_details('ali_medical_history')],
            ['name' => 'Hypertension', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'DM', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Smoker', 'type' => 'select', 'children' => $this->input_details('smoker_status')],
        ];
        $this->insert_input($risk_factors, 'risk_factors', $parent_id);

        $laboratory_findings = [
            ['name' => 'Hb', 'type' => 'number', 'suffix' => 'g/dl'],
            ['name' => 'Leukosit', 'type' => 'number', 'suffix' => '10^3/µl'],
            ['name' => 'Neutrofil', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Limfosit', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Monosit', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Eosinofil', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Basofil', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Neutrophil-Lymphosite Ratio', 'type' => 'number',],
            ['name' => 'Platelete-Lymphosite Ratio', 'type' => 'number',],
            ['name' => 'Lymphosite-Monocyte Ratio', 'type' => 'number',],
            ['name' => 'Trombosit', 'type' => 'number', 'suffix' => '10^3/µl'],
            ['name' => 'Blood glucose', 'type' => 'number', 'suffix' => 'mg/dl'],
            ['name' => 'CRP', 'type' => 'number', 'suffix' => 'mg/L'],
            ['name' => 'Creatinin', 'type' => 'number', 'suffix' => 'mg/dl'],
            ['name' => 'Uric acid', 'type' => 'number', 'suffix' => 'mg/dl'],
        ];

        $this->insert_input($laboratory_findings, 'laboratory_findings', $parent_id);

        $echocardiography = [
            ['name' => 'LA Diameter', 'type' => 'number', 'suffix' => 'mm'],
            ['name' => 'LAVI', 'type' => 'number', 'suffix' => 'ml/m^2'],
            ['name' => 'LVIdd', 'type' => 'number', 'suffix' => 'mm'],
            ['name' => 'EF', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'LA thrombus', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'LV thrombus', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'VHD', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];

        $this->insert_input($echocardiography, 'echocardiography', $parent_id);

        $diagnostic_studies = [
            ['name' => 'Duplex Stenosis/Occlusion', 'type' => 'checkbox', 'children' => $this->input_details('angiography')],
            ['name' => 'Angiography Stenosis/Occlusion', 'type' => 'checkbox', 'children' => $this->input_details('angiography')],
        ];

        $this->insert_input($diagnostic_studies, 'diagnostic_studies', $parent_id);

        $intervention = [
            ['name' => 'Intervention', 'type' => 'checkbox', 'children' => $this->input_details('intervention')],
        ];

        $this->insert_input($intervention, 'intervention', $parent_id);

        $fibrinolytic = [
            ['name' => 'Type', 'type' => 'checkbox', 'children' => $this->input_details('ali_fibrinolytic')],
            ['name' => 'Dose: Bolus', 'type' => 'number', 'suffix' => 'mg/IU'],
            ['name' => 'Dose: Maintenance', 'type' => 'number', 'suffix' => 'mg/IU/hour'],
        ];

        $this->insert_input($fibrinolytic, 'fibrinolytic', $parent_id);

        $treatments = [
//            ['name' => 'Regularly Consumed Drugs', 'type' => 'textarea',],
//            ['name' => 'Inpatient Medication', 'type' => 'textarea'],
            ['name' => 'Treatments', 'type' => 'checkbox', 'children' => $this->input_details('ali_treatments')],
        ];

        $this->insert_input($treatments, 'treatments', $parent_id);
        $outcome = [
            ['name' => 'Amputation', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Time of Amputation after First Admission', 'type' => 'number', 'suffix' => 'day'],
            ['name' => 'Bleeding', 'type' => 'select', 'children' => $this->input_details('bleeding_risk')],
            ['name' => 'Mortality ', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Time of Mortality after First Admission', 'type' => 'number', 'suffix' => 'day'],
            ['name' => 'Cause of Mortality', 'type' => 'textarea'],
            ['name' => 'Reperfusion Injury', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];

        $this->insert_input($outcome, 'outcome', $parent_id);
        return $this->response;
    }

    private function cvi_input()
    {
        $parent_id = 2;
        $identity = [
            ['name' => 'Admission', 'type' => 'date'],
            ['name' => 'Medical Record Number', 'type' => 'text',],
            ['name' => 'Sex', 'type' => 'radio', 'children' => $this->input_details('gender')],
            ['name' => 'Phone Number', 'type' => 'text',],
            ['name' => 'Lenth of Stay', 'type' => 'number', 'suffix' => 'day'],
        ];

        $this->insert_input($identity, 'identity', $parent_id);

        $cvi_risk_factors = [
            ['name' => 'Weight', 'type' => 'number', 'suffix' => 'kg',],
            ['name' => 'Height', 'type' => 'number', 'suffix' => 'cm',],
            ['name' => 'BMI', 'type' => 'select', 'children' => $this->input_details('bmi')],
            ['name' => 'Smoker Status', 'type' => 'select', 'children' => $this->input_details('smoker_status')],
            ['name' => 'Mobility', 'type' => 'select', 'children' => $this->input_details('mobility')],
            ['name' => 'Profession', 'type' => 'text',],
            ['name' => 'Profession >5 hours standing/sitting?', 'type' => 'select', 'children' => $this->input_details('bool')],
            ['name' => 'Family history of CVI', 'type' => 'text',],
            ['name' => 'History of leg ulcers', 'type' => 'text',],
            ['name' => 'Previous leg surgery', 'type' => 'text',],
            ['name' => 'Previous history of thrombosis', 'type' => 'text',],
            ['name' => 'Ankle mobility restrictions', 'type' => 'text',],
            ['name' => 'Bowel habit ', 'type' => 'select', 'children' => $this->input_details('bowel_habit')],
            ['name' => 'Year of diagnosis CVI', 'type' => 'text',],
            ['name' => 'Medical history', 'type' => 'select', 'children' => $this->input_details('cvi_medical_history')],
        ];
        $this->insert_input($cvi_risk_factors, 'cvi_risk_factors', $parent_id);

        $diagnostic_studies = [
            ['name' => 'Duplex Ultrasound', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];
        $this->insert_input($diagnostic_studies, 'diagnostic_studies', $parent_id);

        $leg_condition = [
            ['name' => 'Sign', 'type' => 'checkbox', 'children' => $this->input_details('sign')],
            ['name' => 'Type of Varices', 'type' => 'select', 'children' => $this->input_details('type_varices')],
            ['name' => 'Ulceration', 'type' => 'select', 'children' => $this->input_details('ulceration')],
//            ['name' => 'Ulceration (if Active)', 'type' => 'select', 'children' => $this->input_details('ulceration_active')],
            ['name' => 'Symptoms', 'type' => 'checkbox', 'children' => $this->input_details('symptoms')],
        ];
        $this->insert_input($leg_condition, 'leg_condition', $parent_id);

        $ulceration_if_active = [
            ['name' => 'Pulse palpation', 'type' => 'text'],
            ['name' => 'Location', 'type' => 'text'],
            ['name' => 'Characteristics of the ulcer', 'type' => 'text'],
            ['name' => 'Edges', 'type' => 'text'],
            ['name' => 'Appearance of ulcer bed', 'type' => 'text'],
            ['name' => 'Amount and type of exudates', 'type' => 'text'],
            ['name' => 'Signs of infection', 'type' => 'text'],
        ];
        $this->insert_input($ulceration_if_active, 'ulceration_if_active', $parent_id);

        $scoring_and_classification_systems = [
            ['name' => 'CEAP (Right Leg)', 'type' => 'text'],
            ['name' => 'CEAP (Left Leg)', 'type' => 'text'],
        ];
        $this->insert_input($scoring_and_classification_systems, 'scoring_and_classification_systems', $parent_id);

        $treatments = [
            ['name' => 'Graduated compression stocking CCL', 'type' => 'select', 'children' => $this->input_details('graduated_compression_stocking_ccl')],
            ['name' => 'Drug Treatments', 'type' => 'checkbox', 'children' => $this->input_details('drug_treatments')],
            ['name' => 'Procedures', 'type' => 'select', 'children' => $this->input_details('procedures')],
            ['name' => 'Other Procedures', 'type' => 'text'],
            ['name' => 'Inpatient Medication', 'type' => 'textarea'],
        ];
        $this->insert_input($treatments, 'treatments', $parent_id);

        $quality_of_life_measurement_1 = [
            ['name' => 'During the past four weeks, have you had any pain in your ankles or legs, and how severe has this pain been?', 'type' => 'text'],
            ['name' => 'During the past four weeks, how much trouble have you experienced at work or during your usual daily activities because of your leg problems?', 'type' => 'text'],
            ['name' => 'During the past four weeks, have you slept badly because of your leg problems, and how often?', 'type' => 'text'],
        ];
        $this->insert_input($quality_of_life_measurement_1, 'quality_of_life_measurement_1', $parent_id);

        $quality_of_life_measurement_2 = [
            ['name' => 'Remaining standing for a long time', 'type' => 'text'],
            ['name' => 'Climbing several flights of stairs', 'type' => 'text'],
            ['name' => 'Crouching Kneeling down', 'type' => 'text'],
            ['name' => 'Walking at a brisk pace', 'type' => 'text'],
            ['name' => 'Performing household tasks (e.g. standing and moving around in the kitchen, carrying a child in your arms, ironing, cleaning the floor or dusting the furniture, DIY...)', 'type' => 'text'],
            ['name' => 'Going out for the evening, going to a wedding, a party, a cocktail party', 'type' => 'text'],
            ['name' => 'Playing a sport, exerting yourself physically', 'type' => 'text'],
        ];
        $this->insert_input($quality_of_life_measurement_2, 'quality_of_life_measurement_2', $parent_id);

        $quality_of_life_measurement_3 = [
            ['name' => 'I have felt nervous/tense', 'type' => 'text'],
            ['name' => 'I have become tired quickly', 'type' => 'text'],
            ['name' => 'I have felt I am a burden', 'type' => 'text'],
            ['name' => 'I have had to be cautious all the time', 'type' => 'text'],
            ['name' => 'I have felt embarrassed about showing my legs', 'type' => 'text'],
            ['name' => 'I have become irritated easily', 'type' => 'text'],
            ['name' => 'I have felt as if I am handicapped', 'type' => 'text'],
            ['name' => 'I have found it hard to get going in the morning', 'type' => 'text'],
            ['name' => 'I have not felt like going out', 'type' => 'text'],
        ];

        $this->insert_input($quality_of_life_measurement_3, 'quality_of_life_measurement_3', $parent_id);

        $quality_of_life_measurement = [
            ['name' => 'Score', 'type' => 'text'],
        ];
        $this->insert_input($quality_of_life_measurement, 'quality_of_life_measurement', $parent_id);
    }

    private function aorta_input()
    {
        $parent_id = 3;
        $identity = [
            ['name' => 'Admission', 'type' => 'date'],
            ['name' => 'ICU Admission', 'type' => 'date'],
            ['name' => 'Medical Record Number', 'type' => 'text',],
            ['name' => 'Age', 'type' => 'text', 'suffix' => 'years'],
            ['name' => 'Is Old Age', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Sex', 'type' => 'radio', 'children' => $this->input_details('gender')],
            ['name' => 'Phone Number', 'type' => 'text',],
            ['name' => 'Job', 'type' => 'text',],
            ['name' => 'Ethnic', 'type' => 'text',],
            ['name' => 'Insurance', 'type' => 'text',],
        ];

        $this->insert_input($identity, 'identity', $parent_id);

        $length_of_stay = [
            ['name' => 'Length of stay ICU', 'type' => 'number', 'suffix' => 'days'],
            ['name' => 'Length of stay Hospital', 'type' => 'number', 'suffix' => 'days'],
        ];
        $this->insert_input($length_of_stay, 'length_of_stay', $parent_id);

        $risk_factors = [
            ['name' => 'Weight', 'type' => 'number', 'suffix' => 'kg',],
            ['name' => 'Height', 'type' => 'number', 'suffix' => 'cm',],
            ['name' => 'BMI', 'type' => 'select', 'children' => $this->input_details('bmi')],
            ['name' => 'Hypertension', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Dyslipidemia', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Diabetes', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Smoker', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Atherosclerosis', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Stroke', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Marfan Syndrome', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Pregnancy', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Aneurysm', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Aortic Aneurysm', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Cardiac Catheterization', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Cardiac Surg', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'CABG', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Valve Surgery', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Other', 'type' => 'textarea'],
            ['name' => 'Family History', 'type' => 'textarea'],
        ];
        $this->insert_input($risk_factors, 'risk_factors', $parent_id);

        $medical_history = [
            ['name' => 'Onset', 'type' => 'textarea'],
            ['name' => 'Clinical Sign', 'type' => 'textarea'],
            ['name' => 'Abrupt Pain', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Radiating Pain', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Quality of Pain', 'type' => 'textarea'],
            ['name' => 'Pain Location', 'type' => 'textarea'],
            ['name' => 'Cough', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Dyspneu', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Swallow Difficulty', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Pulsating Feeling', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Syncope', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Paraparesis SCI', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Limb Ischemia', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Asymptomatic ', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];
        $this->insert_input($medical_history, 'medical_history', $parent_id);

        $physical_examination = [
            ['name' => 'Heart Rate', 'type' => 'number'],
            ['name' => 'Pulsation', 'type' => 'number'],
            ['name' => 'Blood pressure (SBP)', 'type' => 'number'],
            ['name' => 'Blood pressure (number)', 'type' => 'number'],
            ['name' => 'Hypotension', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Shock', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'AR/Murmur', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];
        $this->insert_input($physical_examination, 'physical_examination', $parent_id);

        $laboratory_findings = [
            ['name' => 'Hb', 'type' => 'number', 'suffix' => 'g/dl'],
            ['name' => 'Leukosit', 'type' => 'number', 'suffix' => '10^3/µl'],
            ['name' => 'Neutrofil', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Limfosit', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Monosit', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Eosinofil', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Basofil', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Trombosit', 'type' => 'number', 'suffix' => '10^3/µl'],
            ['name' => 'eGFR', 'type' => 'number'],
            ['name' => 'RDW', 'type' => 'number'],
            ['name' => 'D-Dimer', 'type' => 'number'],
            ['name' => 'D-Dimer Range', 'type' => 'select', 'children' => $this->input_details('d_dimer_range')],
            ['name' => 'Fibrinogen', 'type' => 'number'],
            ['name' => 'Fibrinogen Range', 'type' => 'select', 'children' => $this->input_details('fibrinogen')],
            ['name' => 'Blood glucose', 'type' => 'number', 'suffix' => 'mg/dl'],
            ['name' => 'CRP', 'type' => 'number', 'suffix' => 'mg/L'],
            ['name' => 'Creatinin', 'type' => 'number', 'suffix' => 'mg/dl'],
            ['name' => 'COVID 19', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];
        $this->insert_input($laboratory_findings, 'laboratory_findings', $parent_id);

        $ekg = [
            ['name' => 'LVH', 'type' => 'text',],
            ['name' => 'Ischemia', 'type' => 'text',],
            ['name' => 'OMI', 'type' => 'text',],
            ['name' => 'Non Spesific STT', 'type' => 'text',],
        ];
        $this->insert_input($ekg, 'ekg', $parent_id);

        $echocardiography = [
            ['name' => 'Category', 'type' => 'text',],
            ['name' => 'EF', 'type' => 'number', 'suffix' => '%'],
            ['name' => 'Intimal Flap', 'type' => 'text',],
            ['name' => 'AR', 'type' => 'text',],
            ['name' => 'Mitral', 'type' => 'text',],
            ['name' => 'TAPSE', 'type' => 'text',],
        ];
        $this->insert_input($echocardiography, 'echocardiography', $parent_id);

        $rontgen_thorax = [
            ['name' => 'Med Widening', 'type' => 'text',],
            ['name' => 'Cardiomegaly', 'type' => 'text',],
            ['name' => 'Calcification', 'type' => 'text',],
            ['name' => 'Pleural Effusion', 'type' => 'text',],
            ['name' => 'Conclusion', 'type' => 'textarea',],
        ];
        $this->insert_input($rontgen_thorax, 'rontgen_thorax', $parent_id);

        $ct_angiography = [
            ['name' => 'Diameter', 'type' => 'text',],
            ['name' => 'Aortic Root', 'type' => 'textarea',],
            ['name' => 'Ascending Aorta', 'type' => 'textarea',],
            ['name' => 'Aortic Arch', 'type' => 'textarea',],
            ['name' => 'Descending Aorta', 'type' => 'textarea',],
            ['name' => 'Aortic Abd Suprarenal', 'type' => 'textarea',],
            ['name' => 'Aortic Abd Infrarenal', 'type' => 'textarea',],
            ['name' => 'Aortic Dissection', 'type' => 'textarea',],
            ['name' => 'Lumen Size', 'type' => 'text',],
            ['name' => 'Entry Location', 'type' => 'text',],
            ['name' => 'Entry Site', 'type' => 'text',],
            ['name' => 'Re-Entry Site', 'type' => 'text',],
            ['name' => 'Branches Obstruction', 'type' => 'text',],
            ['name' => 'Ulcer', 'type' => 'text',],
            ['name' => 'Mural thrombus', 'type' => 'text',],
            ['name' => 'Impending Rupture', 'type' => 'text',],
            ['name' => 'Rupture', 'type' => 'text',],
            ['name' => 'Intramural Hematome', 'type' => 'text',],
        ];
        $this->insert_input($ct_angiography, 'ct_angiography', $parent_id);

        $msct_coroner = [
            ['name' => 'CAD', 'type' => 'text',],
            ['name' => 'Aortic Dissection', 'type' => 'text',],
            ['name' => 'Stanford', 'type' => 'text',],
            ['name' => 'De Bakey', 'type' => 'text',],
        ];
        $this->insert_input($msct_coroner, 'msct_coroner', $parent_id);

        $diagnose = [
            ['name' => 'Diagnose', 'type' => 'textarea'],
        ];
        $this->insert_input($diagnose, 'diagnose', $parent_id);

        $therapy = [
            ['name' => 'Beta Blocker', 'type' => 'text'],
            ['name' => 'Sodium Nitro', 'type' => 'text'],
            ['name' => 'CCB', 'type' => 'text'],
            ['name' => 'ACEI', 'type' => 'text'],
            ['name' => 'ARB', 'type' => 'text'],
            ['name' => 'Morphine', 'type' => 'text'],
            ['name' => 'Vasoactive', 'type' => 'text'],
            ['name' => 'Blood Transfusion', 'type' => 'text'],
            ['name' => 'Intubation', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Ventilator', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Surgery', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];
        $this->insert_input($therapy, 'therapy', $parent_id);

        $intervention = [
            ['name' => 'Intervention', 'type' => 'text'],
            ['name' => 'Date of Intervention', 'type' => 'date'],
            ['name' => 'Endovascular Intervention', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Intra Op complication', 'type' => 'textarea'],
            ['name' => 'Concomitant Intervention', 'type' => 'text'],
            ['name' => 'TEVAR Access', 'type' => 'text'],
            ['name' => 'TEVAR Brand name', 'type' => 'text'],
            ['name' => 'TEVAR Size', 'type' => 'text'],
            ['name' => 'TEVAR Urgent Stent Graft', 'type' => 'text'],
            ['name' => 'TEVAR Elective Stent Graft', 'type' => 'text'],
            ['name' => 'TEVAR Complication', 'type' => 'text'],
            ['name' => 'EVAR Access', 'type' => 'text'],
            ['name' => 'EVAR Brand name', 'type' => 'text'],
            ['name' => 'EVAR Size', 'type' => 'text'],
            ['name' => 'EVAR Elective Stent Graft', 'type' => 'text'],
            ['name' => 'EVAR Complication', 'type' => 'text'],
        ];
        $this->insert_input($intervention, 'intervention', $parent_id);

        $complication = [
            ['name' => 'Aortic Rupture', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Pericardial Effusion or Cardiac Tamponade', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Pleural Effusion', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'ACS', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Heart Failure', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Pulmonary Edema', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Stroke', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Spinal Ischemia', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Mesenteric Ischemia', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'AKI', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Limb Ischemia', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Mal Perfusion', 'type' => 'radio', 'children' => $this->input_details('bool')],
        ];
        $this->insert_input($complication, 'complication', $parent_id);

        $death = [
            ['name' => 'Time of Death', 'type' => 'date'],
            ['name' => 'In Hospital Death', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'In Hospital Death within 7 days', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Mortality 30 day after admission', 'type' => 'text'],
        ];
        $this->insert_input($death, 'death', $parent_id);

        $follow_up = [
            ['name' => 'Symptomps', 'type' => 'textarea'],
            ['name' => 'Rehospitalization', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Date of Rehospitalization', 'type' => 'date'],
            ['name' => 'Re-Intervention', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Date of Intervention', 'type' => 'date'],
            ['name' => 'Death', 'type' => 'radio', 'children' => $this->input_details('bool')],
            ['name' => 'Date of Death', 'type' => 'date'],
        ];

        $this->insert_input($follow_up, 'follow_up_1', $parent_id);
        $this->insert_input($follow_up, 'follow_up_6', $parent_id);
        $this->insert_input($follow_up, 'follow_up_12', $parent_id);
        $this->insert_input($follow_up, 'follow_up_24', $parent_id);
        $this->insert_input($follow_up, 'follow_up_36', $parent_id);
    }

    private function insert_input($inputs, $cat_label, $parent_id)
    {
        $cat_base = Category::whereParentId($parent_id)->get();
        $cat_cld = Category::whereIn('parent_id', $cat_base->pluck('id'))->get();
        $cats = $cat_base->merge($cat_cld);

        $active_ids = [];
        foreach ($inputs as $input) {
            $cat = $cats->where('label', $cat_label)->first();

            if (!$cat) {
                $this->response['status'] = false;
                $this->response['text'] = $cat_label;
                return $this->response;
            }

            $cat_id = $cat['id'];

            $created = Input::whereName($input['name'])
                ->whereCategoryId($cat_id)
                ->first();

            if ($created) {
                $created->update([
                    'type'         => $input['type'],
                    'note'         => isset($input['note']) ? $input['note'] : null,
                    'prefix'       => isset($input['prefix']) ? $input['prefix'] : null,
                    'suffix'       => isset($input['suffix']) ? $input['suffix'] : null,
                    'is_currency'  => isset($input['is_currency']) ? $input['is_currency'] : 0,
                    'blank_option' => isset($input['blank_option']) ? $input['blank_option'] : 0,
                ]);
            } else {
                $created = Input::create([
                    'category_id'    => $cat_id,
                    'project_id'     => 1,
                    'institution_id' => 1,
                    'user_id'        => 1,
                    'name'           => $input['name'],
                    'type'           => $input['type'],
                    'note'           => isset($input['note']) ? $input['note'] : null,
                    'prefix'         => isset($input['prefix']) ? $input['prefix'] : null,
                    'suffix'         => isset($input['suffix']) ? $input['suffix'] : null,
                    'is_currency'    => isset($input['is_currency']) ? $input['is_currency'] : 0,
                    'blank_option'   => isset($input['blank_option']) ? $input['blank_option'] : 0,
                ]);
            }

            $active_ids[] = $created->id;

            if (isset($input['children']) && count($input['children']) > 0) {
                foreach ($input['children'] as $child) {
                    $created_detail = InputDetail::whereInputId($created['id'])
                        ->whereName($child['name'])
                        ->first();

                    if ($created_detail) {
                        $created_detail->update([
                            'input_type' => $created['type'],
                            'value'      => $child['value'],
                        ]);
                    } else {
                        InputDetail::create([
                            'input_id'   => $created->id,
                            'input_type' => $created->type,
                            'name'       => $child['name'],
                            'value'      => $child['value'],
                        ]);
                    }
                }
            }
        }

        Input::where('category_id', $cat_id)
            ->whereNotIn('id', $active_ids)->update([
                'status' => 0
            ]);

        return $this->response;
    }

    private function input_details($name)
    {
        $data['ali_treatments'] = [
            ['name' => 'Aspirin', 'value' => 'aspirin',],
            ['name' => 'Clopidogrel', 'value' => 'clopidogrel',],
            ['name' => 'Statin', 'value' => 'statin',],
            ['name' => 'Ace inhibitor', 'value' => 'ace_inhibitor',],
            ['name' => 'ARB', 'value' => 'arb',],
            ['name' => 'UFH', 'value' => 'ufh',],
            ['name' => 'LMWH', 'value' => 'lmwh',],
            ['name' => 'Fondaparinux', 'value' => 'fondaparinux',],
            ['name' => 'Cilostazole', 'value' => 'cilostazole',],
            ['name' => 'Pentoxifilin', 'value' => 'pentoxifilin',],
            ['name' => 'Allopurinol', 'value' => 'allopurinol',],
            ['name' => 'Other', 'value' => 'other',],
        ];

        $data['ali_fibrinolytic'] = [
            ['name' => 'Alteplase', 'value' => 'alteplase',],
            ['name' => 'Streptokinase', 'value' => 'streptokinase',],
            ['name' => 'Urokinase', 'value' => 'urokinase',],
        ];

        $data['gender'] = [
            ['name' => 'Male', 'value' => 'M',],
            ['name' => 'Female', 'value' => 'F',]
        ];

        $data['bool'] = [
            ['name' => 'Yes', 'value' => 'yes',],
            ['name' => 'No', 'value' => 'no',]
        ];

        $data['sensory_loss'] = [
            ['name' => 'None', 'value' => 'none',],
            ['name' => 'Toes', 'value' => 'toes',],
            ['name' => 'Above Toes', 'value' => 'above_toes',],
        ];

        $data['rutherford'] = [
            ['name' => 'I', 'value' => 'I',],
            ['name' => 'IIA', 'value' => 'IIA',],
            ['name' => 'IIB', 'value' => 'IIB',],
            ['name' => 'III', 'value' => 'III',],
        ];

        $data['fibrinogen'] = [
            ['name' => '<238', 'value' => '<238',],
            ['name' => '238-498', 'value' => '238-498',],
            ['name' => '>498', 'value' => '>498',],
        ];

        $data['d_dimer_range'] = [
            ['name' => '<500', 'value' => '<500',],
            ['name' => '500-1000', 'value' => '500-1000',],
            ['name' => '1000-5000', 'value' => '1000-5000',],
            ['name' => '>5000', 'value' => '>5000',],
        ];

        $data['bowel_habit'] = [
            ['name' => 'Normal', 'value' => 'normal',],
            ['name' => 'Constipation', 'value' => 'constipation',]
        ];

        $data['drug_treatments'] = [
            ['name' => 'OAC', 'value' => 'oac',],
            ['name' => 'Diuretics', 'value' => 'diuretics',],
            ['name' => 'Flavonoids/Phlebotonics', 'value' => 'flavonoids_phlebotonics',],
            ['name' => 'Sulodexide', 'value' => 'sulodexide',],
            ['name' => 'Pentoxifylline', 'value' => 'pentoxifylline',],
            ['name' => 'ASA', 'value' => 'asa',],
        ];

        $data['procedures'] = [
            ['name' => 'Ever undergone high stripping and ligation', 'value' => 'ever_undergone_high_stripping_and_ligation',],
            ['name' => 'Ever undergone phlebectomy', 'value' => 'ever_undergone_phlebectomy',],
            ['name' => 'Foam Sclerotherapy', 'value' => 'foam_sclerotherapy',],
            ['name' => 'EVLA', 'value' => 'evla',],
            ['name' => 'Other', 'value' => 'other',],
        ];

        $data['ulceration_active'] = [
            ['name' => 'Pulse palpation', 'value' => 'pulse_palpation',],
            ['name' => 'Location', 'value' => 'location',],
            ['name' => 'Characteristics of the ulcer', 'value' => 'characteristics_of_the_ulcer',],
            ['name' => 'Edges', 'value' => 'edges',],
            ['name' => 'Appearance of ulcer bed', 'value' => 'appearance_of_ulcer_bed',],
            ['name' => 'Amount and type of exudates', 'value' => 'amount_and_type_of_exudates',],
            ['name' => 'Signs of infection', 'value' => 'signs_of_infection',],
        ];

        $data['graduated_compression_stocking_ccl'] = [
            ['name' => 'Short Stretch GCS', 'value' => 'short_stretch_gcs',],
            ['name' => 'Long Stretch GCS', 'value' => 'long_stretch_gcs',],
        ];

        $data['ulceration'] = [
            ['name' => 'No Ulceration', 'value' => 'no_ulceration',],
            ['name' => 'Healed', 'value' => 'healed',],
            ['name' => 'Active', 'value' => 'active',],
        ];

        $data['symptoms'] = [
            ['name' => 'Cramps', 'value' => 'cramps',],
            ['name' => 'Tiredness', 'value' => 'tiredness',],
            ['name' => 'Burning sensation', 'value' => 'burning_sensation',],
            ['name' => 'Leg discomfort', 'value' => 'leg_discomfort',],
            ['name' => 'Heaviness', 'value' => 'heaviness',],
            ['name' => 'Itching', 'value' => 'itching',],
            ['name' => 'Paraesthesia', 'value' => 'paraesthesia',],
            ['name' => 'Pain', 'value' => 'pain',],
        ];

        $data['smoker_status'] = [
            ['name' => 'Smoker', 'value' => 'smoker',],
            ['name' => 'Passive Smoker', 'value' => 'passive-smoker',],
            ['name' => 'Ex-Smoker', 'value' => 'ex-smoker',],
            ['name' => 'Never Smoker', 'value' => 'never-smoke',],
        ];

        $data['bmi'] = [
            ['name' => 'Healthy', 'value' => 'healthy',],
            ['name' => 'Overweight', 'value' => 'overweight',],
            ['name' => 'Obesity', 'value' => 'obesity',],
        ];

        $data['mobility'] = [
            ['name' => 'Active', 'value' => 'active',],
            ['name' => 'Sedentary', 'value' => 'sedentary',],
        ];

        //CDT, Thrombus Aspiration, Balloon Angioplasty, Angiojet, Penumbra, EKOS, Surgical Embolectomy
        $data['intervention'] = [
            ['name' => 'CDT', 'value' => 'cdt',],
            ['name' => 'Thrombus Aspiration', 'value' => 'thrombus_aspiration',],
            ['name' => 'Balloon Angioplasty', 'value' => 'balloon_angioplasty',],
            ['name' => 'Angiojet', 'value' => 'angiojet',],
            ['name' => 'Penumbra', 'value' => 'penumbra',],
            ['name' => 'EKOS', 'value' => 'ekos',],
            ['name' => 'Surgical Embolectomy', 'value' => 'surgical_embolectomy',],
        ];

        $data['type_varices'] = [
            ['name' => 'Teleangiectasis', 'value' => 'teleangiectasis',],
            ['name' => 'Reticular Veins', 'value' => 'reticular_veins',],
            ['name' => 'Varicose Veins', 'value' => 'varicose_veins',],
        ];

        $data['bleeding_risk'] = [
            ['name' => 'Minor', 'value' => 'minor',],
            ['name' => 'Mayor', 'value' => 'mayor',],
            ['name' => 'Live Threatening', 'value' => 'live_threatening',],
        ];

        $data['ali_medical_history'] = [
            ['name' => 'CVD', 'value' => 'cvd'],
            ['name' => 'Family History with CVD', 'value' => 'family_cvd'],
            ['name' => 'Malignancy', 'value' => 'malignancy'],
            ['name' => 'Autoimmune', 'value' => 'autoimmune'],
            ['name' => 'Other', 'value' => 'other'],
        ];

        $data['cvi_medical_history'] = [
            ['name' => 'DM', 'value' => 'dm'],
            ['name' => 'HBP', 'value' => 'hbp'],
            ['name' => 'Renal Disease', 'value' => 'renal_disease'],
        ];

        $data['angiography'] = [
            ['name' => 'Tibial', 'value' => 'tibial'],
            ['name' => 'Popliteal', 'value' => 'popliteal'],
            ['name' => 'Femoral', 'value' => 'femoral'],
            ['name' => 'Illiac', 'value' => 'illiac'],
            ['name' => 'Aorta', 'value' => 'aorta'],
            ['name' => 'Subclavia', 'value' => 'aubclavia'],
            ['name' => 'Axillaris', 'value' => 'axillaris'],
            ['name' => 'Brachialis', 'value' => 'brachialis'],
            ['name' => 'Radialis', 'value' => 'radialis'],
            ['name' => 'Ulnaris', 'value' => 'ulnaris'],
        ];

        $data['sign'] = [
            ['name' => 'Swelling (Oedema)', 'value' => 'swelling_oedema'],
            ['name' => 'Chronic Skin Changes', 'value' => 'chronic_skin_changes'],
            ['name' => 'Cellulitis', 'value' => 'cellulitis'],
            ['name' => 'Venous Eczema', 'value' => 'venous_eczema'],
            ['name' => 'Atrophie Blanche', 'value' => 'atrophie_blanche'],
            ['name' => 'Varicophlebitis', 'value' => 'varicophlebitis'],
            ['name' => 'Varicorrhage', 'value' => 'varicorrhage'],
            ['name' => 'Lymphedema', 'value' => 'lymphedema'],
            ['name' => 'Lipodermatosclerosis', 'value' => 'lipodermatosclerosis'],
            ['name' => 'Other Dermatitis', 'value' => 'other_dermatitis'],
        ];

        $selected = isset($data[$name]) ? $data[$name] : null;

        if ($selected) {
            return $selected;
        } else {
            return [];
        }
    }

    public function password()
    {
        return Hash::make('password');
    }
}


