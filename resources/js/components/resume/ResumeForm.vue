<template>
  <div>
    <Alert v-if="Array.isArray(alert.messages) && alert.messages.length >0 || typeof alert.messages === 'string'"
    :messages="alert.messages"
    :type="alert.type"/>
    <div class="row mb-3">
      <div class="col-sm-8">
        <div class="form-group">
          <input v-model="resume.title" placeholder="Resume Title" required autofocus class="form-control w-100" />
        </div>
      </div>
      <div class="col-sm-4">
        <button class="btn btn-success btn-block" @click="submit()">
          Submit <i class="fa fa-upload"></i>
        </button>
      </div>
    </div>
    <Tabs>
      <Tab title="Basics" icon="fas fa-user">
        <VueFormGenerator :schema="schemas.basics" :model="resume.content.basics" :options="options" />
        <VueFormGenerator :schema="schemas.location" :model="resume.content.basics.location" :options="options" />
      </Tab>
      <Tab title="Profiles" icon="fa fa-users">
        <DynamicForm title="Profile" self="profiles" :model="resume.content.basics" :schema="schemas.profiles" />
      </Tab>
      <Tab title="Work" icon="fa fa-briefcase">
        <DynamicForm title="Work" self="work" :model="resume.content" :schema="schemas.work"
          :subforms="subforms.work" />
      </Tab>
      <Tab title="Education" icon="fa fa-graduation-cap">
        <DynamicForm title="Education" self="education" :model="resume.content" :schema="schemas.education"
          :subforms="subforms.education" />
      </Tab>
      <Tab title="Skills" icon="fa fa-lightbulb">
        <DynamicForm title="Skill" self="skills" :model="resume.content" :schema="schemas.skills"
          :subforms="subforms.skills" />
      </Tab>
      <Tab title="Awards" icon="fa fa-trophy">
        <DynamicForm title="Awards" self="awards" :model="resume.content" :schema="schemas.awards" />
      </Tab>
    </Tabs>
  </div>
</template>

<script>
import jsonresume from './jsonresume.js';
import basics from './schema/basics/basics.js';
import location from './schema/basics/location.js';
import profiles from './schema/basics/profiles.js';
import work from './schema/work.js';
import education from './schema/education.js';
import skills from './schema/skills.js';
import awards from './schema/awards.js';
import Alert from '../reusable/Alert';
import Tabs from './tabs/Tabs.vue';
import Tab from './tabs/Tab.vue';
import { component as VueFormGenerator } from 'vue-form-generator';
import 'vue-form-generator/dist/vfg.css';
import DynamicForm from './dynamic/DynamicForm.vue';
import ListForm from './dynamic/ListForm.vue';


export default {
  name: 'ResumeForm',

  components: {
    VueFormGenerator,
    DynamicForm,
    Alert,
    Tabs,
    Tab,
  },

  props: {
    update: false,
    resume: {
      type: Object,
      default: () => ({
        id: null,
        title: 'Resume Title',
        content: jsonresume,
      }),
    }


  },

  data() {
    return {
      alert: {
        type: 'warning',
        messages: [],
      },
      schemas: {
        basics,
        location,
        profiles,
        work,
        education,
        awards,
        skills,
      },

      subforms: {
        work: [
          {
            component: ListForm,
            props: {
              title: 'highlights',
              self: 'highlights',
              placeholder: 'Started the company',
            }
          }
        ],
        education: [
          {
            component: ListForm,
            props: {
              title: 'courses',
              self: 'courses',
              placeholder: 'DB1101 - Basic SQL',
            }
          }
        ],
        skills: [
          {
            component: ListForm,
            props: {
              title: 'keywords',
              self: 'keywords',
              placeholder: 'JavaScript',
            }
          }
        ]
      },

      options: {
        validateAfterLoad: true,
        validateAfterChanged: true,
        validateAsync: true,
      },
    };
  },

  methods: {
    validate(target, parent = 'resume'){
      let errors = [];
      for (const [prop, value] of Object.entries(target)) {
        if (Array.isArray(value)){
          if (value.length === 0){
            errors.push(`${parent} > ${prop} must have least one element`);
            continue;
          }
          for (const i in value){
            if (typeof value[i] === null || value[i] === ''){
              errors.push(`${parent} > ${prop} > ${i} cannot be empty`);
            } else if (typeof value[i] === 'object') {
              errors = errors.concat(
                this.validate(value[i], `${parent} > ${prop} > ${i}`)
              );
            }
          }
        }else if (typeof value === 'object'){
          errors = errors.concat(
            this.validate(value, `${parent} > ${prop}`)
          );
        }else if (value === null || value === ''){
          errors.push(`${parent} > ${prop} is required`);
        }
      }

      return errors;
    },

    isValid(){
      const {alert} = this.$data;
      const {resume} = this.$props;
      alert.messages = [];
      const errors = this.validate(resume.content);
      console.log(errors);
      if(errors.length <1){
        return true;
      }

      alert.messages = errors.slice(0, 3);
      if (errors.length > 3){
        alert.messages.push(
          `<strong>${errors.length - 3} more errors ...</strong>`
        )
      }
      alert.type = 'warning';

      return false;
    },

    async submit() {
      if (!this.isValid()){
        return;
      }

      const {alert} = this.$data;
      const {resume, update} = this.$props;
      
      try {
      const res = this.update
        ? await axios.put(route('resumes.update', resume.id), resume)
        : await axios.post(route('resumes.store'), resume);
        console.log(res);
        window.location = route('resumes.index');
      } catch (e) {
        alert.messages = [];
        const errors = e.response.data.errors;
        for (const [prop, value] of Object.entries(errors)){
          let origin = prop.split('.');
          if(origin[0] === 'content'){
            origin.splice(0, 1);
          }
          origin = origin.join(' > ');
          for (const error of value){
            const message = error.replace(prop, `<strong>${origin}</strong>`);
            alert.messages.push(message);
          }
        }

        alert.type = 'danger';
      }
    }
  }
};
</script>

