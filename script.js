const selects = document.querySelectorAll('.colorSelect');
const messageDiv = document.getElementById('message');

selects.forEach((select) => {
   // Record last value in case user selects duplicate
   select.dataset.prev = select.value;

   select.addEventListener('focus', function () {
      this.dataset.prev = this.value;
   });

   select.addEventListener('change', function () {
      let selectedValues = [];

      selects.forEach((s) => {
         if (s !== this) {
            selectedValues.push(s.value);
         }
      });

      // Check for duplicate
      if (selectedValues.includes(this.value)) {
         // Previous value
         this.value = this.dataset.prev;

         messageDiv.textContent =
            'That color is already in use. Please choose a different one.';
      } else {
         // Update preview cell
         const row = this.closest('tr');
         const previewCell = row.querySelector('.preview');
         previewCell.textContent = this.value;

         // Clear
         messageDiv.textContent = '';
      }
   });
});
