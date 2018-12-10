Requires package `pdftk` installed ... so I don't see an advantage over the 
`demo_pdftk` script.  And the PHP still has to be allowed to `exec()`.  Also
very picky about having a correct reference to the `pdftk` binary in 
`pdf-php-stuff/libfpdm/export/pdf/pdftk.php` - you will likely need to change it
for your system/deployment.  Check at lines 91-99 in the version provided here
and fix as needed for your own use.

Create a text document in OpenOffice and insert a textbox or two from the Form 
menu.  Double click on it to set the name, font size, border style (none), etc.
All you need in this document is the form elements to be filled out via the PHP
code.  Save it (editing later, just in case) and then Export as PDF.  Be sure 
to check the box to make it a PDF Form, using FDF for submission.

Next, use the `pdftk` utility to generate the FDF document info for your form
document - `pdftk your_form.pdf generate_fdf`.  Enter a file name as prompted.

Copy your FDF file two times - once for the header, once for the footer.  Next, 
open them in your preferred plain text editor.  Look for the line

     /Fields [

(see line 7 in `../file_parts/cert_form.fdf`)

Which will be followed by references to your input fields, something like this,
possibly broken into multiple lines -

     << /T (Text Box 1) /V ( ) >>

(lines 8-11,12-15 in `../file_parts/cert_form.fdf`)

Your Field definitions end at the next closing bracket character `]` (line 16 in
`../file_parts/cert_form.fdf`)

In the header file, remove everything after the opening bracket for the Fields. 

In the footer file, remove everything before the closing bracket for the Fields.

See `../file_parts/cert_form_header.fdf` and `../file_parts/cert_form_footer.fdf` 
for examples.

Basically, you will use the header, add the field references with whatever data
you want on your PDF certificate, and then finish with the footer.

In the `demo_fpdm.php` file (lines 9-18), you'll need to generate the FDF field line 
for each input box on the form.  Be sure to reference the field names correctly.

Naturally you'll want to populate the data from some type of external method, 
perhaps by POST, a LTI call from a LMS, reading from a DB and outputting to a 
file instead of the browser as a stream, etc.

