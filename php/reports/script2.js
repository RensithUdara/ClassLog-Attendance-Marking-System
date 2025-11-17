$(document).ready(function () {
    $("#report-form").show();
    $("#report-form-step3").show();

    function loadSubjects() {
        $.ajax({
            url: "student_get_subject.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    const subjectDropdown = $('#subject');
                    subjectDropdown.empty();
                    subjectDropdown.append('<option value="">Select Subject</option>');
                    data.forEach(subject => {
                        // Display subject_code and subject_name in option text, use subject_id as value
                        subjectDropdown.append(
                            `<option value="${subject.subject_id}">${subject.subject_code} - ${subject.subject_name}</option>`
                        );
                    });
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while fetching subjects. Please try again.");
                console.log("Response Text:", xhr.responseText);
            }
        });
    }

    loadSubjects();

    $("#generate-report").on("click", function () {
        const subjectId = $("#subject").val();
        if (subjectId) {
            window.location.href = `student_view_graph.php?subject_id=${subjectId}`;
        } else {
            alert("Please select a subject to generate the report.");
        }
    });
});
