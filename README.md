
Playing with creating/filling PDFs via PHP code - think generate a certificate
of completion, etc.

Code under the `libfpdm` directory is from another project. Please see the file
`libfpd/LICENSE` for more information.

The code under `demo_fpdm` and `demo_pdftk` is authored by me and is released 
under the GPLv2.

Note that both demo scripts require `pdftk` to be installed on the web host, and
PHP must allow the `exec()` function.  The `demo_fpdm` uses `libfpdm` which is 
somewhat picky about finding the `pdftk` binary.  See `demo_fpdm/README.md` for
more information.

