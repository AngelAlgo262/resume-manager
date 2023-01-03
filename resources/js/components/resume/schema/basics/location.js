const padding = ['p-0', 'pr-md-1'];
const ColMd4 = ['col-md-4', ...padding];
const ColMd6 = ['col-md-6', ...padding];

export default {
  fields: [
    //Address
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Your Address',
      label: 'Address',
      model: 'address',
      styleClasses: ColMd4,
    },
    //CP
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Your Postal Code',
      label: 'Postal Code',
      model: 'postalCode',
      styleClasses: ColMd4,
    },
    //City
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Your city',
      label: 'City',
      model: 'city',
      styleClasses: ColMd4,
    },
    //Country code
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'MX',
      label: 'Country Code',
      model: 'countryCode',
      styleClasses: ColMd6,
    },
    //Region
    {
      type: 'input',
      inputType: 'text',
      placeholder: 'Your Region',
      label: 'Region',
      model: 'region',
      styleClasses: ColMd6,
    },
  ],
};
