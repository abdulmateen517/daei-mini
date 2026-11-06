

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.routineDashboard = () => ({
    user:null,admin:false,section:'assessment',loading:true,saving:false,mobileNav:false,error:'',toast:'',
    stats:{users:0,groups:0,reports_today:0,pending_reviews:0},users:[],groups:[],reports:[],history:[],summary:{activities:[],completed_activities:0,total_activities:0,report_date:''},report:null,selectedUser:null,
    filters:{user_id:'',date:'',status:''},feedback:{comment:'',suggestions:''},form:{work_summary:'',challenges:'',learning:'',rating:0,reflection:''},
    async request(url,options={}){const response=await fetch(url,{credentials:'same-origin',...options,headers:{Accept:'application/json','Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||'',...(options.headers||{})}});const data=await response.json().catch(()=>({}));if(!response.ok)throw new Error(data.errors?Object.values(data.errors)[0][0]:(data.message||`Request failed (${response.status})`));return data;},
    rows(payload){return payload?.data||[];},
    async init(){try{this.user=await this.request('/api/user');this.admin=Boolean(this.user.is_admin||this.user.role==='admin');this.section=this.admin?'overview':'assessment';await Promise.all([this.loadAssessment(),this.loadHistory()]);if(this.admin)await this.loadAdmin();}catch(e){this.error=e.message;}finally{this.loading=false;}},
    async loadAdmin(){const [d,u,g,r]=await Promise.all([this.request('/api/admin/dashboard'),this.request('/api/admin/users'),this.request('/api/admin/groups'),this.request('/api/admin/reports')]);this.stats=d.stats;this.users=this.rows(u);this.groups=this.rows(g);this.reports=this.rows(r);},
    async loadAssessment(){const x=await this.request('/api/daily-summary');this.summary=x.data;const h=await this.request('/api/daily-reports');const saved=this.rows(h).find(r=>String(r.report_date).slice(0,10)===this.summary.report_date);if(saved)this.form={work_summary:saved.work_summary||'',challenges:saved.challenges||'',learning:saved.learning||'',rating:saved.rating||0,reflection:saved.reflection||''};},
    async loadHistory(){this.history=this.rows(await this.request('/api/daily-reports'));},
    get completion(){return this.summary.total_activities?Math.round(this.summary.completed_activities*100/this.summary.total_activities):0;},
    async loadReports(){const p=new URLSearchParams(Object.entries(this.filters).filter(([,v])=>v));this.reports=this.rows(await this.request(`/api/admin/reports${p.size?`?${p}`:''}`));},
    async submitReport(){this.saving=true;this.error='';try{await this.request('/api/daily-reports',{method:'POST',body:JSON.stringify({...this.form,date:this.summary.report_date})});await this.loadHistory();this.notify('Your daily reflection was submitted.');}catch(e){this.error=e.message;}finally{this.saving=false;}},
    async openReport(id){try{this.report=(await this.request(`/api/admin/reports/${id}`)).data;this.feedback={comment:'',suggestions:''};}catch(e){this.error=e.message;}},
    async openOwnReport(id){try{this.report=(await this.request(`/api/daily-reports/${id}`)).data;}catch(e){this.error=e.message;}},
    async sendFeedback(){try{await this.request(`/api/admin/reports/${this.report.id}/feedback`,{method:'POST',body:JSON.stringify(this.feedback)});await this.loadReports();await this.openReport(this.report.id);this.notify('Feedback sent.');}catch(e){this.error=e.message;}},
    async setStatus(status){try{await this.request(`/api/admin/reports/${this.report.id}/status`,{method:'PATCH',body:JSON.stringify({status})});await this.loadReports();await this.openReport(this.report.id);this.notify(`Report marked ${status}.`);}catch(e){this.error=e.message;}},
    async openUser(id){try{this.selectedUser=await this.request(`/api/admin/users/${id}`);}catch(e){this.error=e.message;}},
    notify(message){this.toast=message;setTimeout(()=>this.toast='',3000);},
});

Alpine.start();
