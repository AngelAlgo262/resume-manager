export default {
  fields: [
    //Company
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Company Name',
      label: 'Company',
      model: 'company',
      styleClasses: ['col-md-4', 'p-0', 'pr-md-1'],
    },
    //Position
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Job Title',
      label: 'Position',
      model: 'position',
      styleClasses: ['col-md-4', 'p-0', 'pr-md-1'],
    },
    //Website
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'https://company.com',
      label: 'Website',
      model: 'website',
      validator: 'url',
      styleClasses: ['col-md-4', 'p-0', 'pr-md-1'],
    },
    // Start Date
    {
      type: 'input',
      inputType: 'date',
      format: 'YYYY-MM-DD HH:mm:ss',
      label: 'Start Date',
      model: 'startDate',
      styleClasses: ['col-md-6', 'p-0', 'pr-md-1'],
    },
    // End Date
    {
      type: 'input',
      inputType: 'date',
      format: 'YYYY-MM-DD HH:mm:ss',
      label: 'End Date',
      model: 'endDate',
      styleClasses: ['col-md-6', 'p-0'],
    },
    // Summary
    {
      type: 'textArea',
      inputType: 'text',
      label: 'Summary',
      placeholder: 'What was this job about?',
      model: 'summary',
    },
  ],
};
