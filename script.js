'use strict';

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

  window.location = '/index.php?show_completed=' + isChecked;
});

var $tasksCheckboxes = document.getElementsByClassName('tasks')[0];
$tasksCheckboxes.addEventListener('change', function (event) {
  if (event.target.classList.contains('task__checkbox')) {
    var checkbox = event.target;
    var isChecked = +checkbox.checked;
    var taskID = checkbox.getAttribute('value');

    window.location = '/index.php?task_id=' + taskID + '&check=' + isChecked;
  }
});

flatpickr('#date', {
  enableTime: true,
  dateFormat: "Y-m-d H:i",
  time_24hr: true,
  locale: "ru"
});
