import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { OpeninstructorComponent } from './openinstructor.component';

describe('OpeninstructorComponent', () => {
  let component: OpeninstructorComponent;
  let fixture: ComponentFixture<OpeninstructorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ OpeninstructorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(OpeninstructorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
