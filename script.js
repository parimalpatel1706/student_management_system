// script.js

const API = {
    add:   'add_student.php',
    fetch: 'fetch_students.php',
    del:   'delete_student.php'
  };
  
  document.addEventListener('DOMContentLoaded', () => {
    const form  = document.getElementById('studentForm');
    const tbody = document.querySelector('#studentList tbody');
  
    // Load initial list
    loadStudents();
  
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const name   = form.studentName.value.trim();
      const age    = form.studentAge.value.trim();
      const course = form.studentCourse.value.trim();
  
      if (!name || !age || !course) return;
  
      // Send to PHP
      const res = await fetch(API.add, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ name, age, course })
      });
      const json = await res.json();
      if (json.status === 'success') {
        prependStudentRow(json.student);
        form.reset();
      } else {
        alert(json.message || 'Error adding student');
      }
    });
  
    async function loadStudents() {
      const res = await fetch(API.fetch);
      const json = await res.json();
      if (json.status === 'success') {
        tbody.innerHTML = '';
        json.students.forEach(s => prependStudentRow(s));
      }
    }
  
    function prependStudentRow(s) {
      const row = tbody.insertRow(0);
      row.dataset.id = s.id;
  
      row.insertCell(0).textContent = s.name;
      row.insertCell(1).textContent = s.age;
      row.insertCell(2).textContent = s.course;
  
      const actionCell = row.insertCell(3);
      const btn = document.createElement('button');
      btn.textContent = 'Delete';
      btn.classList.add('delete');
      btn.addEventListener('click', () => deleteStudent(s.id, row));
      actionCell.appendChild(btn);
    }
  
    async function deleteStudent(id, row) {
      if (!confirm('Delete this student?')) return;
      const res = await fetch(API.del, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id })
      });
      const json = await res.json();
      if (json.status === 'success') {
        row.remove();
      } else {
        alert(json.message || 'Error deleting student');
      }
    }
  });
  