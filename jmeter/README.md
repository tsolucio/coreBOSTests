### How to convert normal test to stress test

One approach is to apply the same changes you apply in the normal test suite to the stress test suite but if the set of changes is big you can start from the normal test suite and follow these steps to get an updated version of the stress test suite.

- copy normal test suite to a new file
- open the new file
- change URL and port if necessary
- eliminate doLoginPortal tests
- In "Information Operations" change Loops to 9 and Threads to 5 (or adapt as required)
- In "CRUD Operations" changes loops 4 to and Threads to 5 (or adapt as required)
- Eliminate
  - the test Retrieve Quotes
  - the section "Update and Revise"
  - the section "RetrieveUpdateRetrieveRevise"
  - the section "Set/Unset Relations"
  - the section "Process Operations"
- In "Other Operations" change Loops to 9 and Threads to 5 (or adapt as required)
- Launch, verify and adapt as needed


