<?php

$conn = new mysqli('localhost', 'root', '', 'checklist');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



function fetch_students($conn) {
    $sql_students = "SELECT * FROM students";
    $result_students = $conn->query($sql_students);
    return $result_students;
}

function fetch_courses_by_semester($conn, $semester_title, $start_id, $end_id) {
    $sql = "SELECT courses.course_id, courses.course_title, courses.credit_unit_lec, 
    courses.credit_unit_lab, courses.contact_hours_lec, courses.contact_hours_lab, 
    courses.pre_requisite, courses.grade_year, courses.academic_year, courses.semester, 
    grades.grade, student_enroll.professor
    FROM courses
    LEFT JOIN grades ON courses.course_id = grades.course_id
    LEFT JOIN student_enroll ON courses.course_id = student_enroll.course_id
    WHERE courses.id BETWEEN $start_id AND $end_id";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query Failed: " . $conn->error);
    }

    $courses = array();
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    return $courses;
}


?>