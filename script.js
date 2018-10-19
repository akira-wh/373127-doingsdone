'use strict';

var updateURLParameter = function (url, parameter, value) {
  url = String(url);

  var urlParameters = url.split('?')[1];

  if (!urlParameters) {
    return url + '?' + parameter + '=' + value;
  }

  var searchPattern = new RegExp('(' + parameter + '=\\d*\\w*)', 'gi');

  if (!searchPattern.test(urlParameters)) {
    return url + '&' + parameter + '=' + value;
  }

  return url.replace(searchPattern, function(match) {
    return parameter + '=' + value;
  });
};

var $showCompletedTasksCheckbox = document.getElementsByClassName('show_completed')[0];
$showCompletedTasksCheckbox.addEventListener('change', function (event) {
  var checkbox = event.target;
  var isChecked = +checkbox.checked;

  window.location = updateURLParameter(window.location, 'show_completed', isChecked);
});

var $tasksCheckboxes = document.getElementsByClassName('tasks')[0];
$tasksCheckboxes.addEventListener('change', function (event) {
  if (event.target.classList.contains('task__checkbox')) {
    var checkbox = event.target;
    var isChecked = +checkbox.checked;
    var taskID = checkbox.getAttribute('value');

    var urlWithTaskData = updateURLParameter(window.location, 'task_id', taskID);
    urlWithTaskData = updateURLParameter(urlWithTaskData, 'check', isChecked);

    window.location = urlWithTaskData;
  }
});

// flatpickr('#date', {
//   enableTime: true,
//   dateFormat: "Y-m-d H:i",
//   time_24hr: true,
//   locale: "ru"
// });
