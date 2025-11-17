$(document).ready(function() {
    // Show the report form when 'Generate Reports' is clicked
    $('#add-report').click(function() {
        $('.form-slide').hide();
        $('#add-report').hide();
        $('#event-report').hide();
        $('#report-form').show();
    });

    $('#event-report').click(function() {
        $('.form-slide').hide();
        $('#add-report').hide();
        $('#event-report').hide();  // Hide any other forms (if needed)
        $('#event-form').show();  // Show the event form
    });
    
    //lecture report form
    // Fetch batch years when the page loads
    $.ajax({
        url: 'get_batches.php',
        type: 'GET',
        success: function(data) {
            $('#batch-year').html(data); // Populate the batch year dropdown
        }
    });

    // Previous button to go back
    $('#prev-to-home').click(function() {
        $('#report-form').hide();        
        $('#add-report',).show();
        $('#event-report').show();
    });

    // Handle the "Next" button click to fetch relevant departments
    $('#next-to-department').click(function() {
        var batchId = $('#batch-year').val(); // Get the selected batch ID

        // Check if a batch was selected
        if (batchId === '') {
            alert('Please select a Batch Year.');
            return;
        }

        // Hide the current form step and show the next step
        $('#report-form-step1').hide();
        $('#report-form-step2').show();

        // Fetch departments based on the selected batch and lecturer
        $.ajax({
            url: 'get_departments.php',
            type: 'GET',
            data: { batch_id: batchId }, // Pass the selected batch ID to PHP
            success: function(data) {
                $('#department').html(data); // Populate the department dropdown
            }
        });
    });

    // Previous button to go back to batch selection
    $('#prev-to-batch-year').click(function() {
        $('#report-form-step2').hide();
        $('#report-form-step1').show();
    });


    $('#next-to-subject').click(function() {
        var batchId = $('#batch-year').val();      // Get the selected batch ID
        var departmentId = $('#department').val(); // Get the selected department ID
    
        // Ensure both batch and department are selected
        if (batchId === '' || departmentId === '') {
            alert('Please select both a Batch Year and Department.');
            return;
        }
    
        // Hide current step and show the next step
        $('#report-form-step2').hide();
        $('#report-form-step3').show();
    
        // Fetch subjects based on batch, department, and lecturer
        $.ajax({
            url: 'get_subjects.php',
            type: 'GET',
            data: { batch_id: batchId, department_id: departmentId },
            success: function(data) {
                $('#subject').html(data); // Populate the subject dropdown
            }
        });
    });

    $('#prev-to-department').click(function() {
        $('#report-form-step3').hide();
        $('#report-form-step2').show();
    });

    $('#next-to-report-type').click(function() {
        var subject = $('#subject').val();
        
        if (subject === '') {
            alert('Please select a Subject.');
            return;
        }

        $('#report-form-step3').hide();
        $('#report-form-step4').show();
    });
    

    $('#prev-to-subject').click(function() {
        $('#report-form-step4').hide();
        $('#report-form-step3').show();
    });

    // Dynamic field selection based on report type
    $('#report-type').change(function() {
        const reportType = $(this).val();
        const additionalFields = $('#additional-fields');
        
        // Clear previous fields
        additionalFields.empty().hide();

        switch (reportType) {
            case 'semester':
            case 'student':
                const subjectId = $('#subject').val();
            
                // Check if a subject is selected
                if (!subjectId) {
                    alert('Please select a subject to display total lectures.');
                    return;
                }
                
                // Fetch total lectures for the selected subject
                $.ajax({
                    url: 'get_total_lectures.php', // Create this PHP file
                    type: 'GET',
                    data: { subject_id: subjectId },
                    success: function(data) {
                        additionalFields.html(`
                            <label>Total Lectures: <span id="total-lectures">${data}</span></label><br>
                            ${reportType === 'student' ? `
                                <label for="student-id">Enter Student ID:</label>
                                <input type="text" id="student-id" name="student_id" style="border-radius: 8px; padding: 8px; border: 1px solid #ccc;"required><br />
                            ` : ''}
                        `).show();
                    },
                    error: function() {
                        alert("Error fetching total lectures.");
                    }
                });
                break;
            case 'lecture':
                additionalFields.append(`
                    <label for="lecture-date">Select Lecture Date:</label>
                    <select id="scanned-date" name="scanned_date" style="border-radius: 8px; padding: 8px; border: 1px solid #ccc;" required>
                        <option value="">Loading...</option>
                    </select>
                `).show();
                
                // Fetch scanned dates
                const subjectIdLecture = $('#subject').val();
                const batchIdLecture = $('#batch-year').val();
                
                if (subjectIdLecture && batchIdLecture) {
                    $.ajax({
                        url: 'get_scanned_dates.php',
                        type: 'GET',
                        data: { subject_id: subjectIdLecture, batch_id: batchIdLecture },
                        success: function(data) {
                            // Check for errors in the response
                            const response = JSON.parse(data);
                            if (response.error) {
                                alert(response.error);
                                return;
                            }
                            
                            // Populate the scanned date dropdown
                            const scannedDateSelect = $('#scanned-date');
                            scannedDateSelect.empty(); // Clear existing options
                            scannedDateSelect.append('<option value="">Select a scanned date</option>');
                            
                            response.forEach(date => {
                                scannedDateSelect.append(`<option value="${date}">${date}</option>`);
                            });
                        },
                        error: function() {
                            alert("Error fetching scanned dates.");
                        }
                    });
                }
                break;
        
            case 'time_period':
                additionalFields.append(`
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start_date" style="border-radius: 8px; padding: 8px; border: 1px solid #ccc;"required>
                    <br><label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end_date" style="border-radius: 8px; padding: 8px; border: 1px solid #ccc;" required>
                `).show();
                break;
        }
    });

    //event report form
    $('#prev-to-home1').click(function() {
        $('#event-form').hide();  // Hide the event form
        $('#add-report').show();  // Show the initial options (assuming 'add-report' is your main menu)
        $('#event-report').show();  // Show the main event report button
    });

    //generate lecture report
    $('#generate-report').click(function(event) {
        event.preventDefault(); // Prevent form submission
        const batch_id = $('#batch-year').val();
        const department_id = $('#department').val();
        const subject_id = $('#subject').val();
        const report_type = $('#report-type').val();
        let additionalData = {};
    
        // Validate fields
        if (!batch_id || !department_id || !subject_id) {
            alert('Please fill all required fields.');
            return;
        }
    
        // Log the values
        console.log('Batch ID:', batch_id);
        console.log('Department ID:', department_id);
        console.log('Subject ID:', subject_id);
        console.log('Report Type:', report_type);
    
        // Populate additionalData based on report_type
        switch (report_type) {
            case 'semester':
                additionalData = { total_lectures: $('#total-lectures').text() };
                break;
            case 'lecture':
                additionalData = { scanned_date: $('#scanned-date').val() };
                break;
            case 'time_period':
                additionalData = {
                    start_date: $('#start-date').val(),
                    end_date: $('#end-date').val()
                };
                break;
            case 'student':
                additionalData = { 
                    total_lectures: $('#total-lectures').text(),
                    student_id: $('#student-id').val() 
                };
                break;
            default:
                alert('Invalid report type selected.');
                return;
        }
    
        console.log('Additional Data:', additionalData);
    
        $.ajax({
            url: 'generate_report.php',
            type: 'POST',
            dataType: 'json', // Expect JSON response
            data: {
                batch_id,
                department_id,
                subject_id,
                report_type,
                ...additionalData
            },
            success: function(response) {
                console.log("Server raw response:", response); // Log the response exactly as received
                try {
                    // If the response is an object, proceed with it directly; otherwise, parse it as JSON
                    const report = typeof response === 'object' ? response : JSON.parse(response);
                    
                    console.log("Parsed response:", report);
                    
                    // Check for error in the response
                    if (report.error) {
                        alert(report.error);
                        return;
                    }
            
                    // Encode the report data to be sent to view_graph.php
                    const reportDataJson = encodeURIComponent(JSON.stringify(report));
            
                    // Redirect to view_graph.php with the report data
                    window.location.href = `view_graph.php?report_data=${reportDataJson}`;
                } catch (e) {
                    alert("Error parsing response: " + e.message);
                    console.log("Problematic response content:", response);
                }
            }
            
            ,
            error: function() {
                alert("Error generating report.");
            }
        });
    });

    // "Generate Report" button functionality
    $('#generate-event-report').click(function() {
        var eventId = $('#event-id').val();  // Get the entered event number

        // Validate input
        if (eventId === '') {
            alert('Please enter an Event Number.');
            return;
        }

        // Show a loading indicator (optional)
        $('#loadingIndicator').show(); // Assume you have a loading element with this ID

        $.ajax({
            url: 'generate_event_report.php',
            type: 'POST',
            data: { event_id: eventId },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    // Store event data in session storage to pass to view_event_graph.php
                    sessionStorage.setItem('eventData', JSON.stringify(result.data));
                    window.location.href = 'view_event_graph.php';  // Redirect to the report view page
                } else {
                    alert(result.message); // Provide user feedback on error
                }
            },
            error: function() {
                alert('Error retrieving event data. Please try again.'); // User-friendly error message
            },
            complete: function() {
                $('#loadingIndicator').hide(); // Hide loading indicator when the request is complete
            }
        });
    });


    
});

