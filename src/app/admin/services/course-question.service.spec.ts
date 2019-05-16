import { TestBed, inject } from '@angular/core/testing';

import { CourseQuestionService } from './course-question.service';

describe('CourseQuestionService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CourseQuestionService]
    });
  });

  it('should be created', inject([CourseQuestionService], (service: CourseQuestionService) => {
    expect(service).toBeTruthy();
  }));
});
