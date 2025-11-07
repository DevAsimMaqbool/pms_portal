@extends('layouts.app')

@push('style')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Examples -->
        <div class="row mb-12 g-6">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fives.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sitara-e-Qiyadat</h5>
                        <p class="card-text">Chairman’s Leadership Excellence Award</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#SitaraeQiyadat">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-threes.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Fakhr-e-Karkardagi</h5>
                        <p class="card-text">Rector’s Academic Excellence Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#FakhrEKarkardagi">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-twos.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tamgha-e-Tahqeeq</h5>
                        <p class="card-text">Research Excellence Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#TamghaETahqeeq">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-one.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Chaudhry Muhammad Akram</h5>
                        <p class="card-text"> Entrepreneurial Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#ChaudhryMuhammadAkram">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fours.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Service Superheroes</h5>
                        <p class="card-text">Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#ServiceSuperheroes">Explore</a>
                    </div>
                </div>
            </div>


        </div>
        <!-- Examples -->
    </div>

    <div class="modal fade" id="SitaraeQiyadat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel4">Sitara-e-Qiyadat</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="m-6">The Sitara-e-Qiyadat – Chairman’s Leadership Excellence Award has been established to honor outstanding leaders within the Superior University community whose vision, commitment, and influence have set new benchmarks of excellence. This prestigious award recognizes individuals who not only demonstrate exceptional leadership within their areas of responsibility but also embody the spirit of innovation, courage, and service that leadership demands in shaping society.</p>
                                <p class="m-6">The Sitara-e-Qiyadat award symbolizes the pioneering spirit of Superior University: a spirit that believes in leading from the front, creating new possibilities, and making meaningful contributions to society. It is a tribute to those leaders who exemplify Superior’s commitment to excellence, and whose efforts ripple far beyond the boundaries.</p>
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-fives.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Deen of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Support Leader</span>
                                        </td>
                                        <td>Universitry Administration</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Program Leader-UnderGrad of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Program Leader-PostGrad of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Special Initiatives</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best House Leader</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best HOD of Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="FakhrEKarkardagi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="FakhrEKarkardagiTtitle">Fakhr-e-Karkardagi</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center text-white">
                                <p class="m-6">The Fakhr-e-Karkardagi – Rector’s 
                                    Academic Excellence Awards are 
                                    established to celebrate and recognize 
                                    outstanding academic achievement 
                                    across Superior University. This 
                                    prestigious category honors faculty 
                                    members and academic contributors 
                                    who have demonstrated exceptional 
                                    commitment to teaching, curriculum 
                                    innovation, student development, and 
                                    academic leadership.
                                    At Superior University, academic 
                                    excellence is not just about 
                                    knowledge delivery; it is about 
                                    inspiring minds, shaping futures, 
                                    and driving transformation through 
                                    education.</p>
                                <p class="m-6">This award aligns directly 
                                with our vision of leading in teaching 
                                and learning, which has been boldly 
                                advanced through groundbreaking 
                                frameworks such as 3U1M, ETTP, 
                                and now the Character Mastery 
                                Framework. These models have 
                                redefined the educational experience, 
                                focusing on real-world readiness, 
                                entrepreneurship, and leadership, 
                                ensuring that our graduates and our 
                                academic practices are future-proof 
                                and globally competitive.</p>
                                <p class="m-6">The Fakhr-e-Karkardagi awards 
                                continue this pioneering spirit — 
                                acknowledging those who uphold 
                                Superior’s mission by setting 
                                new standards in academic rigor, 
                                innovation, and student engagement. 
                                By celebrating the highest standards 
                                of teaching and learning, the 
                                Fakhr-e-Karkardagi – Rector’s 
                                Academic Excellence Awards affirm 
                                our commitment to nurturing an 
                                environment where educational 
                                excellence is cultivated, recognized, 
                                and further flourished.
                                This recognition strengthens 
                                Superior’s legacy of innovation 
                                in education and encourages 
                                all educators to strive for 
                                transformational impact, both within 
                                their classrooms and beyond.</p>
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-threes.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Faculty Member</span>
                                        </td>
                                        <td>Faculty</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Class Attendance (Recognition)</span>
                                        </td>
                                        <td>Department Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Monthly</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Feedback (Recognition)</span>
                                        </td>
                                        <td>Subject Wise, Department Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Semester</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best FYP Manager</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best QCH</span>
                                        </td>
                                        <td>Faculty</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Batch Advisor</span>
                                        </td>
                                        <td>Faculty</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


       <div class="modal fade" id="TamghaETahqeeq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="TamghaETahqeeqTitle">Tamgha-e-Tahqeeq</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="m-6">The Tamgha-e-Tahqeeq – Research Excellence Award has been instituted to honor the outstanding contributions of researchers who are advancing the frontiers of knowledge, innovation, and societal impact through their scholarly work. This award recognizes individuals and teams who have demonstrated excellence in producing highquality, impactful research that addresses real-world challenges and contributes to the betterment of society.</p>
                                <p class="m-6"> The Research Excellence Awards are closely aligned with Superior University’s vision which sets forth the goal of becoming the leading research university in Pakistan. Through this recognition, Superior University not only applauds individual and collaborative research achievements but also reaffirms its commitment to nurturing an environment where inquiry, exploration, and innovation are deeply valued and continuously rewarded. The Tamgha-e-Tahqeeq serves as both a celebration of past accomplishments and an inspiration for future generations of researchers who will help Superior University soar even higher and roar even louder on the global stage.</p>
                                
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-twos.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Outstanding Researcher of the year Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Young Researcher Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Innovation & Commercialization Award</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
       <div class="modal fade" id="ChaudhryMuhammadAkram" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ChaudhryMuhammadAkramTitle">Chaudhry Muhammad Akram</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center  text-white">
                                <p class="m-6">The Chaudhry Muhammad Akram Entrepreneurial Awards are designed to honor and celebrate the visionary efforts of faculty members who champion the university’s entrepreneurial agenda. This award recognizes those educators who actively promote innovative thinking, creativity, and practical business acumen, helping to transform students into successful entrepreneurs and intrapreneurs. Their initiatives not only foster a spirit of enterprise within the classroom but also bridge the gap between academic theory and real-world practice.</p>
                                <p class="m-6">At Superior University, our commitment to shaping future leaders extends beyond traditional academic boundaries. The Entrepreneurial Awards underscore the institution’s strategic focus on cultivating an entrepreneurial mindset across all disciplines. By integrating entrepreneurial education into the curriculum and encouraging experiential learning, our faculty members are creating dynamic pathways that empower students to identify, pursue, and nurture opportunities in both established industries and emerging sectors. This aligns directly with our broader vision of fostering innovation and preparing our community for leadership in an ever-evolving economic landscape.</p>
                                <p class="m-6">Through the Chaudhry Muhammad Akram Entrepreneurial Awards, Superior University reaffirms its dedication to nurturing a culture where academic excellence and entrepreneurial spirit converge. Recognizing and rewarding these outstanding contributions not only incentivizes further innovation but also inspires a generation of students to challenge the status quo, develop groundbreaking ideas, and ultimately contribute to the sustainable economic growth and social progress of our society.</p>
                                
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-one.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Outstanding Researcher of the year Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Young Researcher Award</span>
                                        </td>
                                        <td>Discipline (Social & Mgmt. Sciences, Engineering & Computing, Medical & Allied Health Sciences)</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Innovation & Commercialization Award</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ServiceSuperheroes" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ServiceSuperheroesTitle">Service Superheroes</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-9 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="m-6">The Service Superheroes Awards are dedicated to recognizing the invaluable contributions of the unsung heroes of Superior University, the office boys, security guards, technical staff, and support teams, whose tireless efforts often go unseen but are absolutely essential to the success of our academic and administrative environment. These individuals work diligently behind the scenes, ensuring that we have a safe, clean, functional, and welcoming space where learning, teaching, and innovation can thrive without disruption.</p>
                                <p class="m-6">By maintaining facilities, securing our surroundings, solving technical challenges, and creating daily convenience for students, faculty, and staff, these dedicated members of our community lay the foundation upon which excellence is built. Their commitment allows the rest of the Superior Family to focus on their pursuits without worry, knowing that the environment around them is in capable and caring hands. Through the Service Superheroes Awards, Superior University proudly shines a light on the spirit of dedication, loyalty, and hard work that these individuals embody every day. This recognition is a testament to our belief that every role, no matter how visible or humble, contributes significantly to our collective success. In celebrating our service superheroes, we reaffirm our core value that every person matters and that our people are truly our pride.</p>
                                
                            </div>
                            <div class="col-md-3 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-fours.png') }}" class="img-fluid" alt="Api Key Image" width="300">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                     <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        
                                        <span class="fw-medium">Best Office Boy</span>
                                        </td>
                                        <td>Campus Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Security Guard</span>
                                        </td>
                                        <td>Campus Wise</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <span class="fw-medium">Best Technical Staff</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                   
                                    
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-ecommerce-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script> --}}


@endpush