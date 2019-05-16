import { TestBed, inject } from '@angular/core/testing';

import { CourseSchedulerService } from './course-scheduler.service';

describe('CourseSchedulerService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CourseSchedulerService]
    });
  });

  it('should be created', inject([CourseSchedulerService], (service: CourseSchedulerService) => {
    expect(service).toBeTruthy();
  }));
});
