import { TestBed, inject } from '@angular/core/testing';

import { ParentcategoryService } from './parentcategory.service';

describe('ParentcategoryService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ParentcategoryService]
    });
  });

  it('should be created', inject([ParentcategoryService], (service: ParentcategoryService) => {
    expect(service).toBeTruthy();
  }));
});
