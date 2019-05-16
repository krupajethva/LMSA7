import { TestBed, inject } from '@angular/core/testing';

import { CourseListService } from './course-list.service';

describe('CourseListService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CourseListService]
    });
  });

  it('should be created', inject([CourseListService], (service: CourseListService) => {
    expect(service).toBeTruthy();
  }));
});
