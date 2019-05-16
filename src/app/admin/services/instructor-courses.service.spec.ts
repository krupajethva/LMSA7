import { TestBed, inject } from '@angular/core/testing';

import { InstructorCoursesService } from './instructor-courses.service';

describe('InstructorCoursesService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [InstructorCoursesService]
    });
  });

  it('should be created', inject([InstructorCoursesService], (service: InstructorCoursesService) => {
    expect(service).toBeTruthy();
  }));
});
