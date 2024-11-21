<?php

foreach ($students as $student) {
    // Ensure 'profile_pic' is not empty or undefined
    echo "{
        id: {$student['id']},
        firstname: '{$student['firstname']}',
        lastname: '{$student['lastname']}',
        profile_pic: '{$student['profile_pic']}', // Check this value
        batch: '{$student['batch']}',
        course: '{$student['course']}'
    },";
}

?>