const padding = ['p-0', 'pr-md-1'];
const ColMd4 = ['col-md-4', ...padding];
const ColMd6 = ['col-md-6', ...padding];

export default {
  fields: [
    //picture
    {
      type: 'resume-image',
      label: 'Resume Profile Image',
      model: 'picture',
    },
    //Name
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Your name',
      label: 'Name',
      model: 'name',
      styleClasses: ColMd4,
    },
    //Label
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Programer',
      label: 'Label',
      model: 'label',
      styleClasses: ColMd4,      
    },
    //Email
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'yourname@email.com',
      label: 'Email',
      model: 'email',
      validator: 'email',
      styleClasses: ColMd4,
    },
    //Phone
    {
      type: 'input',
      inputType: 'tel',
      placeholder: '9786542',
      label: 'Phone',
      model: 'phone',
      styleClasses: ColMd6,
    },
    //Website
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'https://yourwebsite.com',
      label: 'Website',
      model: 'website',
      validator: 'url',
      styleClasses: ColMd6,
    },
    //Summary
    {
      type: 'textArea',
      inputType: 'text',
      placeholder: 'A little bit about yourself ',
      label: 'Summary',
      model: 'summary',
    },
  ],
};
