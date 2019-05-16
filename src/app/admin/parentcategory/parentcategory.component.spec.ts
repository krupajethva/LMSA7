import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ParentcategoryComponent } from './parentcategory.component';

describe('ParentcategoryComponent', () => {
  let component: ParentcategoryComponent;
  let fixture: ComponentFixture<ParentcategoryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ParentcategoryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ParentcategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
