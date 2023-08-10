<?php
require 'sessions.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resume Generator</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 100vh; */
      }

      .container {
        display: flex;
        width: 90%;
        max-width: 1200px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
      }

      .container1 {
        flex: 30%;
        padding: 20px;
        background-color: #f9f9f9;
        border-right: 1px solid #ddd;
      }

      .container2 {
        flex: 70%;
        padding: 20px;
      }

      h4 {
        font-size: 18px;
        margin: 0;
        margin-bottom: 10px;
        color: #333;
      }

      hr {
        margin: 10px 0;
        border: none;
        border-top: 1px solid #ddd;
      }

      p {
        font-size: 16px;
        margin: 5px 0;
        color: #666;
      }

      ul {
        list-style: none;
        padding-left: 0;
      }

      ul li {
        font-size: 16px;
        color: #666;
        margin-left: 20px;
      }

      .image img {
        max-width: 100%;
        border-radius: 50%;
      }
      .profile {
        margin-bottom: 10px;
      }
      .edit-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
      }
      .edit-container {
            display: flex;
            align-items: center; /* Center align items vertically */
            /* justify-content: space-between; */
            
        }
        .delete-container {
            display: flex;
            align-items: center; /* Center align items vertically */
            justify-content: space-between;
            
        }
        .even {
    background-color: #f0f0f0; /* Light gray */
    padding: 10px;
}

.odd {
    background-color: #f9f9f9; /* Slightly darker gray */
    padding: 10px;
}

.contact{
  margin-bottom: 20px;
}
.education{
  margin-bottom: 20px;
}
.skills{
  margin-bottom: 20px;
}
.image {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

.image img {
    max-width: 100%;
    border-radius: 50%;
    margin-bottom: 10px;
}

.image form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.image input[type="file"] {
    margin-bottom: 10px;
}

.image .edit-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

    </style>
  </head>
  <body>
    <div class="container">
      <div class="container1">
      <div class="image">
    <img src="<?php echo $_SESSION['profileImage']; ?>" height="110px" width="125px" alt="Profile Picture" class="profile">
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="profile_image" accept="image/*">
        <button type="submit" name="upload_image" class="edit-btn">Upload Image</button>
    </form>
</div>


        <section class="contact">
    <h4>Contact</h4>
    <hr />

    <?php if ($_SESSION['editing']['contact']) : ?>
        <form method="post">
            <input type="text" name="new_email" placeholder="Email" value="<?php echo $_SESSION['editableContent']['contact']['email']; ?>" required>
            <input type="text" name="new_phone" placeholder="Phone" value="<?php echo $_SESSION['editableContent']['contact']['phone']; ?>" required>
            <input type="text" name="new_address" placeholder="Address" value="<?php echo $_SESSION['editableContent']['contact']['address']; ?>" required>
            <button type="submit" name="save" class="edit-btn">Save</button>
        </form>
    <?php else : ?>
        <p>Email: <?php echo $_SESSION['editableContent']['contact']['email']; ?></p>
        <p>Phone: <?php echo $_SESSION['editableContent']['contact']['phone']; ?></p>
        <p>Address: <?php echo $_SESSION['editableContent']['contact']['address']; ?></p>
        <form method="post">
            <button type="submit" name="edit_contact" class="edit-btn">Edit</button>
        </form>
    <?php endif; ?>
</section>



<section class="education">
    <h4>Education</h4>
    <hr />

    <?php foreach ($_SESSION['education'] as $index => $education) : ?>
        <div class="education-entry <?php echo ($index % 2 == 0) ? 'even' : 'odd'; ?>">
            <div class="delete-container">
                <div>
                    <p><?php echo $education['year'] ?></p>
                    <p><?php echo $education['degree']; ?></p>
                    <p><?php echo $education['university']; ?></p>
                </div>
                <div>
                    <form method="post" class="delete-form">
                        <input type="hidden" name="delete_education_index" value="<?php echo $index; ?>">
                        <button type="submit" name="delete_education" class="delete-btn edit-btn">Delete</button>
                    </form>
                </div>
                <hr />
            </div>
        </div>
    <?php endforeach; ?>

    <form method="post">
        <button type="submit" name="add_education" class="edit-btn">Add Education</button>
    </form>

    <?php if (isset($_POST['add_education'])) : ?>
        <form method="post">
            <div class="edit-container">
                <input type="text" name="new_year" placeholder="Year" required>
                <input type="text" name="new_degree" placeholder="Degree" required>
                <input type="text" name="new_university" placeholder="University" required>
                <button type="submit" name="save_education" class="edit-btn">Save</button>
            </div>
        </form>
    <?php endif; ?>
</section>


<section class="skills">
    <h4>Skills</h4>
    <hr />

    <ul>
        <?php foreach ($_SESSION['skills'] as $skill) : ?>
            <li><?php echo $skill; ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="post">
        <button type="submit" name="add_skill" class="edit-btn">Add Skill</button>
    </form>

    <?php if (isset($_POST['add_skill'])) : ?>
        <form method="post">
            <div class="edit-container">
                <input type="text" name="new_skill" placeholder="Skill" required>
                <button type="submit" name="save_skill" class="edit-btn">Save</button>
            </div>
        </form>
    <?php endif; ?>
</section>


<section class="Languages">
    <h4>Languages</h4>
    <hr />

    <ul>
        <?php foreach ($_SESSION['languages'] as $language) : ?>
            <li><?php echo $language; ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="post">
        <button type="submit" name="add_language" class="edit-btn">Add Language</button>
    </form>

    <?php if (isset($_POST['add_language'])) : ?>
        <form method="post">
            <div class="edit-container">
                <input type="text" name="new_language" placeholder="Language" required>
                <button type="submit" name="save_language" class="edit-btn">Save</button>
            </div>
        </form>
    <?php endif; ?>
</section>

      </div>

      <div class="container2">
      <section class="editable-content">
      <div class="edit-container">
            <?php if ($_SESSION['editing']['name']) : ?>
              <form method="post">
                <input type="text" name="new_name" value="<?php echo $_SESSION['editableContent']['name']; ?>">
                <button type="submit" name="save" class="edit-btn">Save</button>
              </form>
            <?php else : ?>
              <h1><?php echo $_SESSION['editableContent']['name']; ?></h1>
              <form method="post">
                <button type="submit" name="edit_name" class="edit-btn">Edit</button>
              </form>
            <?php endif; ?>
          </div>

          <div class="edit-container">
            <?php if ($_SESSION['editing']['position']) : ?>
              <form method="post">
                <input type="text" name="new_position" value="<?php echo $_SESSION['editableContent']['position']; ?>">
                <button type="submit" name="save" class="edit-btn">Save</button>
              </form>
            <?php else : ?>
              <h3><?php echo $_SESSION['editableContent']['position']; ?></h3>
              <form method="post">
                <button type="submit" name="edit_position" class="edit-btn">Edit</button>
              </form>
            <?php endif; ?>
          </div>

          <div class="edit-container">
            <?php if ($_SESSION['editing']['experience']) : ?>
              <form method="post">
                <textarea name="new_experience"><?php echo $_SESSION['editableContent']['experience']; ?></textarea>
                <button type="submit" name="save" class="edit-btn">Save</button>
              </form>
            <?php else : ?>
              <p><?php echo $_SESSION['editableContent']['experience']; ?></p>
              <form method="post">
                <button type="submit" name="edit_experience" class="edit-btn">Edit</button>
              </form>
            <?php endif; ?>
          </div>
    </section>
    <section class="experience">
                    <h1>Experience</h1>
                    <hr />

                    <?php foreach ($_SESSION['experiences'] as $index => $experience) : ?>
                      <div class="experience-entry <?php echo ($index % 2 == 0) ? 'even' : 'odd'; ?>">
                        <div class="delete-container "> 
                          <div>
                          <p><?php echo $experience['jobposition'] ?></p>
                          <p><?php echo $experience['start'] . '-' . $experience['end']; ?></p>
                          <p><?php echo $experience['company']; ?></p>
                          <p><?php echo $experience['type']; ?></p>
                          </div>
                          <div>
                          <form method="post" class="delete-form">
                              <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                              <button type="submit" name="delete_experience" class="delete-btn edit-btn">Delete</button>
                          </form>
                       </div>
                          <hr />
                          </div>
                      </div>
                    <?php endforeach; ?>

                    <form method="post">
                        <button type="submit" name="add_experience" class="edit-btn">Add Experience</button>
                    </form>

                    <?php if (isset($_POST['add_experience'])) : ?>
                        <form method="post">
                            <div class="edit-container">
                                <input type="text" name="new_job_position" placeholder="Job Position" required>
                                <input type="text" name="new_company" placeholder="Company Name" required>
                                <input type="text" name="new_start" placeholder="Start Year" required>
                                <input type="text" name="new_end" placeholder="End Year" required>
                                <select name="new_type">
                                    <option value="Full Time">Full Time</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Contractual">Contractual</option>
                                </select>
                                <button type="submit" name="save_experience" class="edit-btn">Save</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </section>

                <!-- Display Projects -->
            <section class="project">
              <h1>Projects</h1>
              <hr />

              <?php foreach ($_SESSION['projects'] as $index => $project) : ?>
                <div class="project-entry <?php echo ($index % 2 == 0) ? 'even' : 'odd'; ?>">
                      <div class="delete-container">
                          <div>
                              <p>Project Name: <?php echo $project['name'] ?></p>
                              <p>Project Description: <?php echo $project['description']; ?></p>
                          </div>
                          <div>
                              <form method="post" class="delete-form">
                                  <input type="hidden" name="delete_project_index" value="<?php echo $index; ?>">
                                  <button type="submit" name="delete_project" class="delete-btn edit-btn">Delete</button>
                              </form>
                          </div>
                          <hr />
                      </div>
                  </div>
              <?php endforeach; ?>

              <form method="post">
                  <button type="submit" name="add_project" class="edit-btn">Add Project</button>
              </form>

              <?php if (isset($_POST['add_project'])) : ?>
                  <form method="post">
                      <div class="edit-container">
                          <input type="text" name="new_project_name" placeholder="Project Name" required>
                          <input type="text" name="new_project_description" placeholder="Project Description" required>
                          <button type="submit" name="save_project" class="edit-btn">Save</button>
                      </div>
                  </form>
              <?php endif; ?>
          </section>




      </div>
    </div>
    

  </body>
</html>