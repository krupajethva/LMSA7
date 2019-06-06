import { TestBed } from '@angular/core/testing';

import { CoursebeforereminderService } from './coursebeforereminder.service';

describe('CoursebeforereminderService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CoursebeforereminderService = TestBed.get(CoursebeforereminderService);
    expect(service).toBeTruthy();
  });
});
