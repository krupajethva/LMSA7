import { TestBed, inject } from '@angular/core/testing';

import { LearnerCoursesService } from './learner-courses.service';

describe('LearnerCoursesService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [LearnerCoursesService]
    });
  });

  it('should be created', inject([LearnerCoursesService], (service: LearnerCoursesService) => {
    expect(service).toBeTruthy();
  }));
});
