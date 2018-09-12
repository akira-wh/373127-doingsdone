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

var $checkbox = document.getElementsByClassName('show_completed')[0];
$checkbox.addEventListener('change', function (event) {
  var isChecked = +event.target.checked;
  window.location = '/index.php?show_completed=' + isChecked;
});

var $taskCheckboxes = document.getElementsByClassName('tasks')[0];
$taskCheckboxes.addEventListener('change', function (event) {
  if (event.target.classList.contains('task__checkbox')) {
    var el = event.target;
    var isChecked = +el.checked;
    var taskID = el.getAttribute('value');

    var url = '/index.php?task_id=' + taskID + '&check=' + isChecked;
    window.location = url;
  }
});

flatpickr('#date', {
  enableTime: true,
  dateFormat: "Y-m-d H:i",
  time_24hr: true,
  locale: "ru"
});
