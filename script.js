'use strict';

var updateURLParameter = function (url, parameter, value) {
  // index.php?one=1&two=2
  url = String(url);

  // one=1&two=2
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

var hidePopups = function () {
  [].forEach.call(document.querySelectorAll('.expand-list'), function (item) {
    item.classList.add('hidden');
  });
};
document.body.addEventListener('click', hidePopups, true);

var expandControls = document.querySelectorAll('.expand-control');
[].forEach.call(expandControls, function (item) {
  item.addEventListener('click', function () {
    item.nextElementSibling.classList.toggle('hidden');
  });
});

document.body.addEventListener('click', function (event) {
  var target = event.target;
  var modal = null;

  if (target.classList.contains('open-modal')) {
    var modalID = target.getAttribute('target');
    modal = document.getElementById(modalID);

    if (modal) {
      document.body.classList.add('overlay');
      modal.removeAttribute('hidden');
    }
  }

  if (target.classList.contains('modal__close')) {
    modal = target.parentNode;
    modal.setAttribute('hidden', 'hidden');
    document.body.classList.remove('overlay');
  }
});

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

flatpickr('#date', {
  enableTime: true,
  dateFormat: "Y-m-d H:i",
  time_24hr: true,
  locale: "ru"
});
