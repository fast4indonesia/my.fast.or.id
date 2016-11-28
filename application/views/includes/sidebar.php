<aside class="left-side sidebar-offcanvas <?php echo $this->uri->segment(1) == 'organizationss' ? 'collapse-left' : ''; ?>" style="min-height: 638px;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $this->config->base_url(); ?>assets/img/avatar3.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Hy, Galih Chrissetyo</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo $this->config->base_url(); ?>">
                    <i class="fa fa-dashboard"></i> <span>Home</span>
                </a>
            </li>
            <li>
                <a href="profil.html">
                    <i class="fa  fa-user"></i><span>Profil</span>
                </a>
            </li>

            <li class="<?php echo $controller_name == 'users' ? 'active' : '' ?>">
                <a href="<?php echo $this->config->base_url(); ?>users">
                    <i class="fa fa-user"></i><span>Management Pengguna</span>
                </a>
            </li>

            <li class="<?php echo $controller_name == 'access' ? 'active' : '' ?>">
                <a href="<?php echo $this->config->base_url(); ?>access">
                    <i class="fa fa-gears"></i><span>Management Akses</span>
                </a>
            </li>

            <li class="treeview <?php echo ($this->uri->segment(1) == 'organization') ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-sitemap"></i><span>Struktur Organisasi</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $controller_name == 'settings' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>organization/settings" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Atur Struktur Data
                        </a>
                    </li>
                    <li class="<?php echo $controller_name == 'views' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>organization/view" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            View Struktur Data
                        </a>

                    </li>
                </ul>
            </li>
            <li class="<?php echo $controller_name == 'evaluations' ? 'active' : '' ?>">
                <a href="<?php echo $this->config->base_url(); ?>evaluations">
                    <i class="fa fa-search-plus"></i><span>Penilaian</span>
                </a>
            </li>
            <li class="<?php echo $controller_name == 'assesments' ? 'active' : '' ?>">
                <a href="<?php echo $this->config->base_url(); ?>assesments">
                    <i class="fa fa-check"></i><span>Hasil Assesment</span>
                </a>
            </li>
            <li class="treeview <?php echo ($this->uri->segment(1) == 'fitnproper') ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-group"></i>
                    <span>Fit &amp; Proper</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $controller_name == 'master' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>fitnproper/master" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Master Data
                        </a>
                    </li>
                    <li class="<?php echo $controller_name == 'evaluation' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>fitnproper/evaluation" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Penilaian
                        </a>
                    </li>
                    <li class="<?php echo $controller_name == 'report' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>fitnproper/report" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Laporan
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php echo ($this->uri->segment(1) == 'scheduling' || $controller_name == 'schedulings') ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span>Penjadwalan</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $controller_name == 'semester' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>scheduling/semester" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Penilaian Semesteran</a></li>
                    <li class="<?php echo $controller_name == 'development' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>scheduling/development" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Development Program</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-indent"></i>
                    <span>Development Program</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview active">
                        <a href="#" style="margin-left: 10px;">
                            <i class="fa fa-indent"></i>
                            <span>ADMP</span>
                            <i class="fa pull-right fa-angle-down"></i>
                        </a>
                        <ul class="treeview-menu" style="display: block;">
                            <li><a href="admp-pa.html" style="margin-left: 20px;"><i class="fa fa-angle-double-right"></i>Project Assignment</a></li>
                            <li><a href="admp-je.html" style="margin-left: 20px;"><i class="fa fa-angle-double-right"></i>Job Enrichment</a></li>
                            <li><a href="admp-jen.html" style="margin-left: 20px;"><i class="fa fa-angle-double-right"></i>Job Enlargement</a></li>
                            <li><a href="admp-cmc.html" style="margin-left: 20px;"><i class="fa fa-angle-double-right"></i>CMC</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#" style="margin-left: 10px;">
                            <i class="fa fa-indent"></i>
                            <span>ATMP</span>
                            <i class="fa pull-right fa-angle-left"></i>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                            <li><a href="atmp-iht.html" style="margin-left: 20px;"><i class="fa fa-angle-double-right"></i>In House Training</a></li>
                            <li><a href="atmp-eks.html" style="margin-left: 20px;"><i class="fa fa-angle-double-right"></i>Eksternal</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php echo $this->uri->segment(1) == 'master' ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-suitcase"></i>
                    <span>Master Data</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $controller_name == 'employee' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/employee">
                            <i class="fa fa-angle-double-right"></i>
                            Employee</a></li>

                    <li class="<?php echo $controller_name == 'jabatan' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/jabatan">
                            <i class="fa fa-angle-double-right"></i>
                            Jabatan</a></li>
                    <li class="<?php echo $controller_name == 'profesi' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/profesi">
                            <i class="fa fa-angle-double-right"></i>
                            Profesi</a></li>
                    <li class="<?php echo $controller_name == 'office' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/office">
                            <i class="fa fa-angle-double-right"></i>
                            Kantor</a></li>
                    <li class="<?php echo $controller_name == 'jenjangjabatan' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/jenjangJabatan">
                            <i class="fa fa-angle-double-right"></i>
                            Jenjang Jabatan</a></li>
                    <li class="<?php echo $controller_name == 'kkj' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/kkj">
                            <i class="fa fa-angle-double-right"></i>
                            Peta Jenjang KKJ</a></li>
                    <li class="<?php echo $controller_name == 'grades' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/grades">
                            <i class="fa fa-angle-double-right"></i>
                            Level Kompetensi</a></li>
                    <li class="<?php echo $controller_name == 'competencies' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/competencies">
                            <i class="fa fa-angle-double-right"></i>
                            Kompetensi</a></li>
                    <li class="<?php echo $controller_name == 'fitnproper' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/fitnproper">
                            <i class="fa fa-angle-double-right"></i>
                            Fit & Proper</a></li>
                    <li class="<?php echo $controller_name == 'jobdesk' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/jobdesk">
                            <i class="fa fa-angle-double-right"></i>
                            Jobdesk</a></li>
                    <li class="<?php echo $controller_name == 'evaluation' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/evaluation">
                            <i class="fa fa-angle-double-right"></i>
                            Penilaian</a></li>
                    <li class="<?php echo $controller_name == 'assessment' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>master/assessment">
                            <i class="fa fa-angle-double-right"></i>
                            Assessment</a></li>


                </ul>
            </li>
            <!-- <span>sdms</span> -->
            <li class="treeview <?php echo ($this->uri->segment(1) == 'talent') ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Talent</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $controller_name == 'talentDictionary' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>talent/talentDictionary" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Talent Dictionary</a></li>
                    <li class="<?php echo $controller_name == 'talentMapping' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>talent/talentMapping" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Talent Mapping</a></li>
                    <li class="<?php echo $controller_name == 'talentPool' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>talent/talentPool" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            General Talent Pool</a></li>
                    <li class="<?php echo $controller_name == 'tracerCandidate' ? 'active' : ''; ?>">
                        <a href="<?php echo $this->config->base_url(); ?>talent/tracerCandidate" style="margin-left: 10px;">
                            <i class="fa fa-angle-double-right"></i>
                            Tracer Candidate</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-road"></i>
                    <span>Career System</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="career-path.html" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i>Career Path</a></li>
                    <li><a href="icp-management.html" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i>ICP Management</a></li>
                    <li><a href="icp-self.html" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i>ICP Selft Employee</a></li>
                </ul>
            </li>
            <li>
                <a href="evaluasi.html">
                    <i class="fa fa-laptop"></i><span>Evaluasi</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>