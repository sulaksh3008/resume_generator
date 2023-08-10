<?php
session_start();

// Initialize editable content, editing flags, and experiences
if (!isset($_SESSION['editableContent'])) {
    $_SESSION['editableContent'] = [
        "name" => "Mariana Anderson",
        "position" => "Marketing Manager",
        "experience" => "Lorem ipsum dolor sit amet...",
        "contact" => [
            "email" => "example@example.com",
            "phone" => "123-456-7890",
            "address" => "123 Street, City"
        ]
    ];
}

if (!isset($_SESSION['editing'])) {
    $_SESSION['editing'] = [
        "name" => false,
        "position" => false,
        "experience" => false,
        "contact"=>false
    ];
}

if (!isset($_SESSION['experiences'])) {
  $_SESSION['experiences'] = [
    [
        "jobposition" => "Job position",
        "company" => "Company name",
        "start" => "2019",
        "end" => "2023",
        "type" => "Full Time"
    ],
];
}

if (!isset($_SESSION['projects'])) {
    $_SESSION['projects'] = [];
}

if(!isset($_SESSION['education'])){
    $_SESSION['education'] = [];
}
if (!isset($_SESSION['skills'])) {
    $_SESSION['skills'] = [];
}
if (!isset($_SESSION['languages'])) {
    $_SESSION['languages'] = [];
}
if (!isset($_SESSION['profileImage'])) {
    $_SESSION['profileImage'] = 'pp.jpg';
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['edit_name'])) {
        $_SESSION['editing']['name'] = true;
    } elseif (isset($_POST['edit_position'])) {
        $_SESSION['editing']['position'] = true;
    } elseif (isset($_POST['edit_experience'])) {
        $_SESSION['editing']['experience'] = true;
    } elseif (isset($_POST['save_personal'])) {
        // Process the edited content
        $newName = isset($_POST['new_name']) ? $_POST['new_name'] : $_SESSION['editableContent']['name'];
        $newPosition = isset($_POST['new_position']) ? $_POST['new_position'] : $_SESSION['editableContent']['position'];
        $newExperience = isset($_POST['new_experience']) ? $_POST['new_experience'] : $_SESSION['editableContent']['experience'];

        // Perform saving to a database or file here
        $_SESSION['editableContent']['name'] = $newName;
        $_SESSION['editableContent']['position'] = $newPosition;
        $_SESSION['editableContent']['experience'] = $newExperience;

        // Reset the editing flags
        $_SESSION['editing'] = [
            "name" => false,
            "position" => false,
            "experience" => false,
            "contact" => false
        ];
    } elseif (isset($_POST['save_experience'])) {
        // Add new experience
        $newJobPosition = $_POST['new_job_position'];
        $newCompany = $_POST['new_company'];
        $newStart = $_POST['new_start'];
        $newEnd = $_POST['new_end'];
        $newType = $_POST['new_type'];

        $_SESSION['experiences'][] = [
            "jobposition" => $newJobPosition,
            "company" => $newCompany,
            "start" => $newStart,
            "end" => $newEnd,
            "type" => $newType
        ];
    }
    else if (isset($_POST['delete_experience'])) {
      $deleteIndex = $_POST['delete_index'];

      if (isset($_SESSION['experiences'][$deleteIndex])) {
          unset($_SESSION['experiences'][$deleteIndex]);
          $_SESSION['experiences'] = array_values($_SESSION['experiences']); // Re-index the array
      }
  }

  else if(isset($_POST['add_experience'])){
    echo '<style>.add_experience_btn { display: none; }</style>';
  }

  if (isset($_POST['save_project'])) {
    $newProjectName = $_POST['new_project_name'];
    $newProjectDescription = $_POST['new_project_description'];

    $_SESSION['projects'][] = [
        "name" => $newProjectName,
        "description" => $newProjectDescription
    ];
}

    else if (isset($_POST['delete_project'])) {
        $deleteProjectIndex = $_POST['delete_project_index'];

        if (isset($_SESSION['projects'][$deleteProjectIndex])) {
            unset($_SESSION['projects'][$deleteProjectIndex]);
            $_SESSION['projects'] = array_values($_SESSION['projects']); // Re-index the array
        }
    }
    else if (isset($_POST['add_project'])){
        echo '<style> .add_project_btn{ display: none; }</style>';

    }


    else if (isset($_POST['edit_contact'])) {
        $_SESSION['editing']['contact'] = true;
    } elseif (isset($_POST['save'])) {
        // Process the edited content for the contact section
        $newEmail = $_POST['new_email'];
        $newPhone = $_POST['new_phone'];
        $newAddress = $_POST['new_address'];
    
        // Update session data
        $_SESSION['editableContent']['contact']['email'] = $newEmail;
        $_SESSION['editableContent']['contact']['phone'] = $newPhone;
        $_SESSION['editableContent']['contact']['address'] = $newAddress;
    
        // Reset the editing flag
        $_SESSION['editing']['contact'] = false;
    }
    else if(isset($_POST['add_education'])){
        echo '<style> .add_education_btn{ display: none; }</style>';
    }

    else if (isset($_POST['save_education'])) {
        $newYear = $_POST['new_year'];
        $newDegree = $_POST['new_degree'];
        $newUniversity = $_POST['new_university'];
    
        $_SESSION['education'][] = [
            "year" => $newYear,
            "degree" => $newDegree,
            "university" => $newUniversity
        ];
    }
    
    else if (isset($_POST['delete_education'])) {
        $deleteEducationIndex = $_POST['delete_education_index'];
    
        if (isset($_SESSION['education'][$deleteEducationIndex])) {
            unset($_SESSION['education'][$deleteEducationIndex]);
            $_SESSION['education'] = array_values($_SESSION['education']); // Re-index the array
        }
    }

    else if (isset($_POST['save_skill'])) {
        $newSkill = $_POST['new_skill'];
        $_SESSION['skills'][] = $newSkill;
    }
    else if (isset($_POST['add_skill'])){
        echo '<style>.add_skill_btn { display: none; }</style>';
    }
    else if (isset($_POST['add_language'])){
        echo '<style>.add_language_btn { display: none; }</style>';
    }
    else if (isset($_POST['save_language'])) {
        $newLanguage = $_POST['new_language'];
        $_SESSION['languages'][] = $newLanguage;
    }

    else if (isset($_POST['upload_image'])) {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $tempFilePath = $_FILES['profile_image']['tmp_name'];
            $newFilePath = '' . $_FILES['profile_image']['name'];
    
            if (move_uploaded_file($tempFilePath, $newFilePath)) {
                $_SESSION['profileImage'] = $newFilePath;
            }
        }
    }

    else if (isset($_POST['preview'])) {
        // Hide the edit and preview buttons
        echo '<style>.edit-btn, .preview-button, .input { display: none; }</style>';
    
        // Show the preview section
        echo '<style>.preview { display: block; }</style>';
    }

    else if (isset($_POST['preview'])) {
        header("Location: preview_resume.php");
        exit; // Make sure to exit after the redirect
    }
    
    
  
}
?>